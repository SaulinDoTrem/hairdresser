import { importHtmlTags } from "./utils/htmlImports";
import { login } from "./login";

document.addEventListener("DOMContentLoaded", function () {
    importHtmlTags();
    login();
});
