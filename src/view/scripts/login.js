export const login = () => {
    const form = document.querySelector(".login-form");
    form.addEventListener("submit", function (e) {
        e.preventDefault();
        const userLogin = {
            user_name: e.currentTarget["userName"].value,
            password: e.currentTarget["password"].value,
        };

        signIn(userLogin);
    });
};

const signIn = async (body) => {
    const baseURI = "http://localhost/hairdresser/src/controller";

    const headers = new Headers();

    headers.append("Content-Type", "application/json");

    const configMethod = {
        method: "POST",
        body: JSON.stringify(body),
        headers: headers,
    };

    const token = await fetch(`${baseURI}/login.php`, configMethod)
        .then((response) => (response.status === 200 ? response.json() : null))
        .then((json) => json.data.token)
        .catch((error) => console.log("error:", error));

    console.log(token);
};
