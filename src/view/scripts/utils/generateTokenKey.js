const generateTokenKey = (tokenLength) => {
    const alphabet = "QWERTYUIOPASDFGHJKLZXCVBNMÇ";
    const characters = `${alphabet}${alphabet.toLowerCase()}1234567890!@$%&*_-+~^,<>?`.split("");

    const token = [];

    for (let index = 0; index < tokenLength; index++) {
        token.push(characters[Math.round(Math.random() * characters.length)]);
    }

    return token.join("");
};

console.log(generateTokenKey(200));
