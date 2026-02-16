<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManager;
use Intervention\Image\Facades\Image;
use Intervention\Image\Drivers\Gd\Driver;

class PostController extends Controller
{
    public function __construct(){
        $this->middleware("auth");
    }

    public function create(){
        return view('posts.create');
    }

    public function store()
    {
        $data = request()->validate([
            'desc' => ['required', 'string'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png','max:4096'],
        ]);

        // // 1. Générer un nom unique pour l'image
        // $imageName = time() . '.' . request('images')->getClientOriginalExtension();
        // $imagePath = 'posts/' . $imageName;

        // // 2. Utiliser Intervention Image pour traiter l'image
        // $manager = new ImageManager(new Driver());
        // $image = $manager->read(request('images'));

        // // Optionnel : Redimensionner l'image pour qu'elles soient toutes carrées (ex: 800x800)
        // $image->cover(800, 800);

        // // 3. Sauvegarder l'image physiquement dans storage/app/public/posts
        // // On utilise storage_path pour pointer au bon endroit sur le serveur
        // $image->save(storage_path('app/public/' . $imagePath));

        // // 4. Enregistrer en base de données
        // auth()->user()->posts()->create([
        //     'description' => $data['desc'],
        //     'images' => $imagePath, // On stocke "posts/nom.jpg"
        // ]);

        // Création du post sans image
        $post = auth()->user()->posts()->create(['description' => $data['desc']]);

        // upload plusieurs images
        if(request()->hasFile('images')){
            foreach(request()->file('images') as $file){
                $imageName = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
                $imagePath = 'posts/'.$imageName;

                $manager = new ImageManager(new Driver());
                $image = $manager->read($file);

                // Le recadrement de l'image
                $image->cover(800,800);
                $image->save(storage_path('app/public/'.$imagePath));
                $post->images()->create(['image' => $imagePath]);

            }
        }
        return redirect()->route('app_profil', ['user' => auth()->user()])->with("success","Publication effectué avec succès");
    }

    public function afficheImage(Post $post, PostImage $image){
        if($image->post_id !== $post->id){
            abort(404);
        }
        return view('posts.affiche_image',compact('post','image'));
    }

    //La page qui contient la publication des profils suivis
    public function index(){

        $users = auth()->user()->following->pluck('user_id');//recuperer les user_id du profil auquel utilisateur est abonné
        
        //ajout pour l'utisateur connecté
        $users->push(auth()->id());

        $posts = Post::whereIn('user_id', $users)->with(['user','likes'])->latest()->paginate(20);//recuperation des posts des publications des differents users par ordre decroissant avec la fonction latest()

        
        return view('posts.index',compact('posts'));
    }

    

    //cette fonction qui nous permettre de liker un post
    public function like(): JsonResponse
    {

        $post = Post::find(request()->post_id);//première requête, la recuperation de id de chaque post

        //si la fonction estLikerParAuthUser() nous renvoie false on supprime le like sinon on ajoute le like
        if($post->estLikerParAuthUser()){
             // L'utilisateur a déjà aimé le post, alors supprimez le like
            $res = Like::where([
                'user_id' => auth()->user()->id,
                'post_id' => request()->post_id,
            ])->delete();//si c'est disliker on supprime le like

            if($res){
                $linkCount = Post::find(request()->post_id)->likes->count();
                return response()->json([
                    //comme on a disliker donc on va pas mettre à jour le post avec la première requête c'est pourquoi on refait à nouveau la requête
                    'count' => $linkCount
                ]);
            }
        }else{
             // L'utilisateur n'a pas encore aimé le post, créez un nouveau like
            $like = new Like();
            
            $like->user_id = auth()->user()->id;
            $like->post_id = request()->post_id;
            $like->save();

            $linkCount = Post::find(request()->post_id)->likes->count();
            return response()->json([
                'count' => $linkCount
            ]);
        }
    }

    // suppression d'un post
    public function destroy(Post $post)
{
    $this->authorize('delete', $post);

    $post->delete();

    return response()->json([
        'success' => true,
        'message' => 'Publication supprimé avec succès'
    ]);
}
}
