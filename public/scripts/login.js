const signin = document.getElementById("signin-btn");
const signup = document.getElementById("signup-btn");
const register = document.getElementById("register");
const signinForm = document.getElementById("signin-form");
const signupForm = document.getElementById("signup-form");
const errorDiv = document.getElementById("error-div");
const url = new URL(window.location.href);

const setSignIn = () => {
  signin.classList.value = "text-yellow-600 underline";
  signup.classList.value = "text-gray-600";
  signinForm.classList.remove("hidden");
  signupForm.classList.add("hidden");
  url.searchParams.set("mode", "signin");
  window.history.pushState({}, "", url);
};

const setSignUp = () => {
  signin.classList.value = "text-gray-600";
  signup.classList.value = "text-yellow-600 underline";
  signinForm.classList.add("hidden");
  signupForm.classList.remove("hidden");
  url.searchParams.set("mode", "signup");
  window.history.pushState({}, "", url);
};

signin.addEventListener("click", setSignIn);
signup.addEventListener("click", setSignUp);
register.addEventListener("click", (e) => {
  e.preventDefault();
  setSignUp();
});

if (url.searchParams.get("mode") === "signup") {
  setSignUp();
} else {
  setSignIn();
}
