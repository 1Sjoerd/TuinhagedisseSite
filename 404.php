<style>
* {
    margin: 0px auto;
    padding: 0px;
    text-align: center;
}
body {
    background: repeating-linear-gradient(
    45deg,
    rgb(12, 66, 17),
    rgb(12, 66, 17) 210px,
    rgb(12, 66, 17) 210px,
    rgb(12, 66, 17) 420px
    );
}

.cont_principal {
    position: absolute;  
    width: 100%;
    height: 100%;
    overflow: hidden;
}
.cont_error {
    position: absolute;
    width: 100%;
    height: 300px;
    top: 50%;
    margin-top: -150px;
}

.cont_error > h1 {
    font-family: 'Roboto', sans-serif;
    font-weight: 400;
    font-size: 150px;
    color: #fff;
    position: relative;
    left: -100%;
    transition: all 0.5s;
}

.cont_error > p {
    font-family: 'Roboto', sans-serif; 
    font-weight: 300;
    font-size: 24px;
    letter-spacing: 5px;
    color: #9294AE;
    position: relative;
    left: 100%;
    transition: all 0.5s;
    transition-delay: 0.5s;
}

.button {
    margin-top: 20px;
    padding: 15px 30px;
    font-family: 'Roboto', sans-serif;
    font-size: 18px;
    color: #fff;
    background-color: rgb(43, 148, 53);
    border: none;
    border-radius: 5px;
    cursor: pointer;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    transition: background-color 0.3s, transform 0.2s;
}

.button:hover {
    background-color: rgb(34, 120, 43);
    transform: translateY(-3px);
}

.cont_aura_1, .cont_aura_2 {
    position: absolute;
    background-color: rgb(43, 148, 53);
    box-shadow: 0px 0px 60px 10px rgb(61, 148, 43);
    transition: all 0.5s;
}

.cont_aura_1 {
    width: 300px;
    height: 120%;
    top: 25px;
    right: -340px;
    animation-name: animation_error_1;
    animation-duration: 4s;
    animation-timing-function: linear;
    animation-iteration-count: infinite;
    animation-direction: alternate;
    transform: rotate(20deg);    
}

.cont_aura_2 {
    width: 100%;
    height: 300px;
    right: -10%;
    bottom: -301px;
    z-index: 5;
    animation-name: animation_error_2;
    animation-duration: 4s;
    animation-timing-function: linear;
    animation-iteration-count: infinite;
    animation-direction: alternate;
    transform: rotate(-20deg);    
}

.cont_error_active > .cont_error > h1 {
    left: 0%;
}
.cont_error_active > .cont_error > p {
    left: 0%;
}

/* Keyframes for animation */
@keyframes animation_error_1 {
  from { transform: rotate(20deg); }
  to { transform: rotate(25deg); }
}

@keyframes animation_error_2 {
  from { transform: rotate(-15deg); }
  to { transform: rotate(-20deg); }
}
</style>

<link rel="stylesheet" href="assets/css/global.css">
<div class="container-hagedis"></div>
<div class="cont_principal">
    <div class="cont_error">
        <h1>Oeps!</h1>  
        <p>Dees pagina besjteit neet</p>
        <button class="button" onclick="goBack()">Gank trök</button>
    </div>
    <div class="cont_aura_1"></div>
    <div class="cont_aura_2"></div>
</div>

<script>
    function goBack() {
        window.history.back();
    }

    window.onload = function() {
        document.querySelector('.cont_principal').className = "cont_principal cont_error_active";  
    }
</script>