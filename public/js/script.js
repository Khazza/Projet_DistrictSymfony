document.getElementById('filter-category').addEventListener('change', function(){
    let selectedCategory = this.value;
    let allCategoryGroups = document.querySelectorAll('.category-group');
    let allCategoryTitles = document.querySelectorAll('.section-titlePlat');

    allCategoryGroups.forEach((category, index) => {
        if (selectedCategory === 'all' || category.dataset.category === selectedCategory) {
            category.style.display = 'flex';  // Flex pour conserver la disposition des colonnes
            allCategoryTitles[index].style.display = 'block';  // Affiche le titre de la catégorie correspondante
        } else {
            category.style.display = 'none'; 
            allCategoryTitles[index].style.display = 'none';  // Masque le titre de la catégorie non choisie
        }
    });
});
