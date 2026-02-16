<template>
  <div>
    <!-- Step 1: Warning -->
    <div v-if="step === 1" class="card p-4">
      <h4>Attention</h4>
      <p>
        Vous êtes sur le point de désactiver votre compte. Il sera masqué immédiatement et supprimé définitivement dans 30 jours si vous ne revenez pas. Vous pouvez annuler votre décision via le lien qui vous serez envoyé par email.
      </p>
      <button class="btn btn-secondary" @click="cancel">Annuler</button>
      <button class="btn btn-danger mt-2" @click="nextStep">Continuer</button>
    </div>

    <!-- Step 2: Reasons + Feedback -->
    <div v-if="step === 2" class="card p-4">
      <h4>Pourquoi quittez-vous BIRIN ?</h4>
      <div v-for="reason in reasonsList" :key="reason">
        <input type="checkbox" :value="reason" v-model="selectedReasons"> {{ reason }}
      </div>
      <div class="mt-2">
        <label>Autre commentaire :</label>
        <textarea v-model="feedback" class="form-control"></textarea>
      </div>
      <button class="btn btn-secondary mt-2" @click="prevStep">Retour</button>
      <button class="btn btn-danger mt-2" @click="nextStep" :disabled="selectedReasons.length < 2 && !feedback.trim()">Continuer</button>
    </div>

    <!-- Step 3: Confirm Password -->
    <div v-if="step === 3" class="card p-4">
      <h4>🔒 Confirmez votre mot de passe</h4>
      <input type="password" v-model="password" class="form-control" placeholder="Mot de passe">
      <div class="mt-2">
        <button class="btn btn-secondary" @click="prevStep">Retour</button>
        <button class="btn btn-danger" @click="submitDeletion">Supprimer mon compte</button>
      </div>
    </div>

    <!-- Step 4: Success -->
    <div v-if="step === 4" class="card p-4">
      <h4>Compte désactivé</h4>
      <p>
        Votre compte a été désactivé avec succès. Un email a été envoyé avec un lien pour annuler la suppression dans les 30 jours.
      </p>
      <a href="/" class="btn btn-primary">Retour à l’accueil</a>
    </div>

    <!-- Error -->
    <div v-if="error" class="alert alert-danger mt-3">
      {{ error }}
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      step: 1,
      reasonsList: [
        "J'aime les autres plateforme",
        "Je n’utilise plus cette plateforme",
        "Problèmes techniques",
        "Je souhaite protéger mes données",
        "Autre"
      ],
      selectedReasons: [],
      feedback: '',
      password: '',
      error: null,
    }
  },
  methods: {
    nextStep() {
      this.error = null;
      //Bloquer si moins de 2 raisons et feedback vide
      if(this.step === 2 && this.selectedReasons.length < 2 && !this.feedback.trim()){
        this.error = "Veuillez sélectionner au moins 2 raisons ou rédiger un commentaire.";
        return;
      }
      this.step++;
    },
    prevStep() {
      this.error = null;
      this.step--;
    },
    cancel() {
      window.location = '/';
    },
    async submitDeletion() {
      this.error = null;
      // Validation frontend
      if(this.selectedReasons.length < 2 && !this.feedback.trim()){
        this.error = "Veuillez sélectionner au moins 2 raisons ou rédiger un commentaire.";
        return;
      }
      try {
        await axios.post('/account/delete', {
          password: this.password,
          reasons: this.selectedReasons,
          feedback: this.feedback
        });
        this.step = 4; // Success step
      } catch (e) {
        if (e.response && e.response.data.errors) {
          this.error = Object.values(e.response.data.errors).flat().join(' ');
        } else {
          this.error = 'Une erreur est survenue. Veuillez réessayer.';
        }
      }
    }
  }
}
</script>

<style scoped>
.card {
  border: 1px solid #ddd;
  border-radius: 8px;
}
</style>