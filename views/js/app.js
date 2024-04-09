// Obtener la ruta actual (por ejemplo, "/personas")
// const currentPath = window.location.pathname;
function extractController(queryString) {
    const params = new URLSearchParams(queryString);
    const controllerParam = params.get('controller');
    return controllerParam || null;
}
const currentPath = ((window.location.search=='')?window.location.pathname:'') + window.location.search;
// const currentPath = "/" + window.location.search;
console.log(currentPath);
// Obtener todos los elementos de navegación
var currentPathE=extractController(currentPath);
const navItems = document.querySelectorAll('.nav-link');
console.log("navItems: ",navItems);
// Iterar sobre los elementos y verificar si la ruta coincide
navItems.forEach(item => {
  const href = item.getAttribute('href');
  var hrefE=extractController(href);
  console.log("href: ", href);
  if (hrefE === currentPathE) {
    console.log("es igual en: "+href+" y "+currentPath);
    item.classList.add('active');
  }
});