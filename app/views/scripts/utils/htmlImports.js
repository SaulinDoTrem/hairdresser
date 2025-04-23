import { readFileAsText } from "./readFile";

export const importHtmlTags = async () => {
    const pageIconLink = document.createElement("link");

    pageIconLink.rel = "icon";
    pageIconLink.href = "./assets/imgs/hairdresser-icon.png";

    const cssImport = document.createElement("link");

    cssImport.rel = "stylesheet";
    cssImport.href = "./main.css";

    const pageTitle = document.createElement("title");

    pageTitle.text = "Hairdresser";

    [cssImport, pageIconLink, pageTitle].forEach((e) => document.head.appendChild(e));

    const fileDirectory = "./partials";

    [`${fileDirectory}/header.html`, `${fileDirectory}/footer.html`].forEach((filePath) =>
        readFileAsText(buildHtmlBody, filePath)
    );
};

const buildHtmlBody = (fileText, fileName) => {
    const element = document.createElement(fileName);
    element.innerHTML = fileText.split(`<${fileName}>`)[1].split(`</${fileName}>`)[0];

    switch (fileName) {
        case "footer":
            {
                const children = document.body.children;
                const newChildren = [];
                for (let i = 0; i < children.length; i++) {
                    newChildren.push(children.item(i));
                    if (children.item(i).tagName === "MAIN") newChildren.push(element);
                }
                document.body.replaceChildren(...newChildren);
            }
            break;
        case "header":
            {
                const children = document.body.children;
                const newChildren = [];
                for (let i = 0; i < children.length; i++) {
                    if (children.item(i).tagName === "MAIN") newChildren.push(element);
                    newChildren.push(children.item(i));
                }
                document.body.replaceChildren(...newChildren);
            }
            break;
        default: {
            console.log("Non-know archive.");
        }
    }
};
