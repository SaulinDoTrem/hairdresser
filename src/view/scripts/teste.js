const alfabeto = "ABCDEFGHIJKLMNOPQRSTUVWXYZ".toLowerCase().split("");
function criaSequenciaDePalavrasAleatorias(tamanho) {
    const string = [];
    for (let index = 0; index < tamanho; index++) {
        string.push(alfabeto[Math.round(Math.random() * alfabeto.length)]);
    }
    return string.join("");
}

console.log(criaSequenciaDePalavrasAleatorias(200));
