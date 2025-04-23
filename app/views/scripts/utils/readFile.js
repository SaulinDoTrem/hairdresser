export const readFileAsText = async (fnCallback, filePath) => {
    const fileText = await fetch(filePath).then((file) => file.text());

    const fileDirectories = filePath.split("./")[1].split("/");
    const fileName = fileDirectories[fileDirectories.length - 1].split(".")[0];

    fnCallback(fileText, fileName);
};
