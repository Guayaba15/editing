function mostrarBotones() {
    const inputDisciplina = document.getElementById("dis");
    const disciplina = inputDisciplina.value;

    const kardex = document.getElementById("kardex");
    const curp = document.getElementById("curp");
    const cedula = document.getElementById("cedula");
    const nss = document.getElementById("nss");
    const anexos = document.getElementById("anexos");
    const ficha = document.getElementById("ficha");
    const certificado = document.getElementById("certificado");
    const monografia = document.getElementById("monografia");
    const audio = document.getElementById("audio");

    // Oculta todos los botones al principio
    [kardex, curp, cedula, nss, anexos, ficha, certificado, monografia, audio].forEach(button => {
        button.style.display = "none";
        button.removeAttribute("required");
    });

    // Mostrar botones según el valor de la disciplina
    if (
        disciplina === "Baloncesto" ||
        disciplina === "Voleibol" ||
        disciplina === "Futbol 7" ||
        disciplina === "Futbol asociacin" ||
        disciplina === "Beisbol" ||
        disciplina === "Softbol" ||
        disciplina === "Rondalla" ||
        disciplina === "Atletismo"
      ) {
        [kardex, curp, cedula, nss].forEach(button => {
            button.style.display = "block";
            button.setAttribute("required", "true");
        });
    } else if (
        disciplina === "Oratoria" ||
        disciplina === "Mural en gis" ||
        disciplina === "Declamacion"
      ) {
        [kardex, curp, cedula, nss, anexos].forEach(button => {
            button.style.display = "block";
            button.setAttribute("required", "true");
        });
    } else if (disciplina === "Ajedrez") {
        [kardex, curp, cedula, nss, ficha].forEach(button => {
            button.style.display = "block";
            button.setAttribute("required", "true");
        });
    } else if (disciplina === "Taekwondo") {
        [kardex, curp, cedula, nss, certificado].forEach(button => {
            button.style.display = "block";
            button.setAttribute("required", "true");
        });
    } else if (disciplina === "Danza") {
        [kardex, curp, cedula, nss, audio, monografia].forEach(button => {
            button.style.display = "block";
            button.setAttribute("required", "true");
        });
    } else if (disciplina === "Canto") {
        [kardex, curp, cedula, nss, audio].forEach(button => {
            button.style.display = "block";
            button.setAttribute("required", "true");
        });
    }
}

// Asignar el evento "input" al campo de entrada para que llame a la función mostrarBotones
const inputDisciplina = document.getElementById("dis");
inputDisciplina.addEventListener("input", mostrarBotones);

// Llamar a mostrarBotones inicialmente para mostrar u ocultar botones en función del valor inicial del campo de entrada
mostrarBotones();
