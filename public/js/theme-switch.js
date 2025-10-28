var base_url = window.location.origin;

var cardColor, headingColor, labelColor, shadeColor, grayColor;
var styleKeyName = 'templateCustomizer-Style';
var themeMode = localStorage.getItem(styleKeyName) ?? 'light';

var coreCssLink = document.createElement("link");
coreCssLink.rel = "stylesheet";
coreCssLink.href = themeMode === "dark" ? (base_url + "/assets/vendor/css/rtl/core-dark.css") : (base_url + "/assets/vendor/css/rtl/core.css");
coreCssLink.classList.add("template-customizer-core-css");
document.head.appendChild(coreCssLink);

var themeCssLink = document.createElement("link");
themeCssLink.rel = "stylesheet";
themeCssLink.href = themeMode === "dark" ? (base_url + "/assets/vendor/css/rtl/theme-default-dark.css") : (base_url + "/assets/vendor/css/rtl/theme-default.css");
themeCssLink.classList.add("template-customizer-theme-css");
document.head.appendChild(themeCssLink);

var htmlElement = document.documentElement; // Select the <html> element
if (themeMode === "dark") {
    htmlElement.classList.remove("light-style");
    htmlElement.classList.add("dark-style");
} else {
    htmlElement.classList.remove("dark-style");
    htmlElement.classList.add("light-style");
}
