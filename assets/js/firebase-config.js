// firebase-config.js
import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
import { getAuth, GoogleAuthProvider } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-auth.js";

// Configurazione Firebase
const firebaseConfig = {
  apiKey: "AIzaSyBvAV1Id3SNM9S1kKYfwEM4dq--sMiioIo",
  authDomain: "primo-progetto-7f9e7.firebaseapp.com",
  databaseURL: "https://primo-progetto-7f9e7-default-rtdb.firebaseio.com",
  projectId: "primo-progetto-7f9e7",
  storageBucket: "primo-progetto-7f9e7.appspot.com",
  messagingSenderId: "665658176474",
  appId: "1:665658176474:web:3305f564d2da0ca0ec86e3",
  measurementId: "G-G8TVVF06LG"
};

// Inizializza Firebase
const app = initializeApp(firebaseConfig);
const auth = getAuth(app);
const provider = new GoogleAuthProvider();

console.log("Firebase configurato e inizializzato.");

export { auth, provider };
