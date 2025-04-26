const auth = firebase.auth();
const provider = new firebase.auth.GoogleAuthProvider();

document.getElementById("loginBtn").addEventListener("click", () => {
  auth.signInWithPopup(provider)
    .then(result => {
      const user = result.user;
      document.getElementById("userInfo").innerHTML =
        `<p>Ciao, ${user.displayName}</p><img src="${user.photoURL}" width="50" />`;
    })
    .catch(error => {
      console.error("Errore login:", error);
    });
});
