const sign_in_btn = document.querySelector("#sign-in-btn");
const sign_up_btn = document.querySelector("#sign-up-btn");
const container = document.querySelector(".container");

sign_up_btn.addEventListener("click", () => {
  container.classList.add("sign-up-mode");
});

sign_in_btn.addEventListener("click", () => {
  container.classList.remove("sign-up-mode");
});

 const password = document.getElementById("password");
    const confirmPassword = document.getElementById("confirmPassword");
    const message = document.getElementById("message");
    const signupBtn = document.getElementById("signupBtn");

    signupBtn.addEventListener("click", () => {
      if (password.value !== confirmPassword.value) {
        message.textContent = "❌ Passwords do not match!";
        message.className = "message error";
      } else {
        message.textContent = "✅ Passwords match! Account created successfully.";
        message.className = "message success";
      }
    });

const correctPassword = "password"; // ← Change this to your password
    let attempts = 0;
    const maxAttempts = 5;
    const lockTime = 60; // seconds
    let lockEndTime = null;
    let timerInterval = null;

    const passwordInput = document.getElementById("password");
    const loginBtn = document.getElementById("loginBtn");
    const note = document.getElementById("note");
    const timerDisplay = document.getElementById("timer");

    loginBtn.addEventListener("click", () => {
      const entered = passwordInput.value;

      if (lockEndTime && Date.now() < lockEndTime) {
        note.textContent = "Please wait for the timer to finish!";
        return;
      }

      if (entered === correctPassword) {
        note.textContent = "✅ Login successful!";
        attempts = 0;
        timerDisplay.textContent = "";
      } else {
        attempts++;
        if (attempts >= maxAttempts) {
          startLockout();
        } else {
          note.textContent = `❌ Wrong password. Attempts left: ${maxAttempts - attempts}`;
        }
      }
      passwordInput.value = "";
    });

    function startLockout() {
      lockEndTime = Date.now() + lockTime * 1000;
      note.textContent = "Too many failed attempts. Locked for 1 minute!";
      loginBtn.disabled = true;
      passwordInput.disabled = true;
      updateTimer();

      timerInterval = setInterval(() => {
        updateTimer();
        if (Date.now() >= lockEndTime) {
          clearInterval(timerInterval);
          unlock();
        }
      }, 1000);
    }

    function updateTimer() {
      const remaining = Math.max(0, Math.floor((lockEndTime - Date.now()) / 1000));
      timerDisplay.textContent = `⏱ Time remaining: ${remaining}s`;
    }

    function unlock() {
      loginBtn.disabled = false;
      passwordInput.disabled = false;
      timerDisplay.textContent = "";
      note.textContent = "You can try again now.";
      attempts = 0;
    }