// Obtener la ruta actual (por ejemplo, "/personas")
// const currentPath = window.location.pathname;
const currentPath = ((window.location.search=='')?window.location.pathname:'') + window.location.search;
// const currentPath = "/" + window.location.search;
console.log(currentPath);
// Obtener todos los elementos de navegación
const navItems = document.querySelectorAll('.nav-link');
console.log("navItems: ",navItems);
// Iterar sobre los elementos y verificar si la ruta coincide
navItems.forEach(item => {
  const href = item.getAttribute('href');
  console.log("href: ", href);
  if (href === currentPath) {
    console.log("es igual en: "+href+" y "+currentPath);
    item.classList.add('active');
  }
});