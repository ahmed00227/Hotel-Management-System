<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Code Input</title>

    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #4070f4;
        }

        :where(.container, form, .input-field, header) {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .container {
            background: #fff;
            padding: 30px 65px;
            border-radius: 12px;
            row-gap: 20px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .container header {
            height: 65px;
            width: 65px;
            background: #4070f4;
            color: #fff;
            font-size: 2.5rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container h4 {
            font-size: 1.25rem;
            color: #333;
            font-weight: 500;
        }

        form .input-field {
            flex-direction: row;
            column-gap: 10px;
        }

        .input-field input {
            height: 45px;
            width: 42px;
            border-radius: 6px;
            outline: none;
            font-size: 1.125rem;
            text-align: center;
            border: 1px solid #ddd;
        }

        .input-field input:focus {
            box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1);
        }

        .input-field input::-webkit-inner-spin-button,
        .input-field input::-webkit-outer-spin-button {
            display: none;
        }

        form button {
            margin-top: 25px;
            width: 100%;
            color: #fff;
            font-size: 1rem;
            border: none;
            padding: 9px 0;
            cursor: pointer;
            border-radius: 6px;
            pointer-events: none;
            background: #6e93f7;
            transition: all 0.2s ease;
        }

        form button.active {
            background: #4070f4;
            pointer-events: auto;
        }

        form button:hover {
            background: #0e4bf1;
        }

        .resend-btn {
            margin-top: 15px;
            background: none;
            border: none;
            color: #4070f4;
            cursor: pointer;
            font-size: 1rem;
            text-decoration: underline;
        }
    </style>
</head>
<body>
{{--@include('header')--}}
<div class="container">
    <h1>OTP Verification</h1>
    <header>
        ✓
    </header>
    <h4>Check your email for the OTP</h4>
    <form id="otp-form" action="{{route('verify')}}" method="post">
        @csrf
        <div class="input-field">
            <input type="number" maxlength="1"/>
            <input type="number" maxlength="1" disabled/>
            <input type="number" maxlength="1" disabled/>
            <input type="number" maxlength="1" disabled/>
        </div>
        <input type="text" id="fullCode" name="otp" class="hidden-input" hidden>
        <button type="submit">Verify</button>
    </form>
    <a class="resend-btn" href="{{route('resend')}}">Resend Code</a>
    <a href="{{route('logout')}}"> logout</a>
</div>
<script>
    const inputs = document.querySelectorAll(".input-field input"),
        button = document.querySelector("button[type='submit']");

    inputs.forEach((input, index1) => {
        input.addEventListener("keyup", (e) => {
            const currentInput = input,
                nextInput = input.nextElementSibling,
                prevInput = input.previousElementSibling;

            if (currentInput.value.length > 1) {
                currentInput.value = "";
                return;
            }

            if (nextInput && nextInput.hasAttribute("disabled") && currentInput.value !== "") {
                nextInput.removeAttribute("disabled");
                nextInput.focus();
            }

            if (e.key === "Backspace") {
                inputs.forEach((input, index2) => {
                    if (index1 <= index2 && prevInput) {
                        input.setAttribute("disabled", true);
                        input.value = "";
                        prevInput.focus();
                    }
                });
            }

            if (!inputs[3].disabled && inputs[3].value !== "") {
                button.classList.add("active");
                return;
            }
            button.classList.remove("active");
        });
    });

    window.addEventListener("load", () => inputs[0].focus());

    document.getElementById('otp-form').addEventListener('submit', (e) => {
        combineCode();
    });

    function combineCode() {
        const inputs = document.querySelectorAll('.input-field input');
        let fullCode = '';
        inputs.forEach(input => {
            fullCode += input.value;
        });
        document.getElementById('fullCode').value = fullCode;
    }

    function resendCode() {
        alert("OTP has been resent to your email.");
    }
</script>
</body>
</html>
