function filterProjects() {
    const query = document.getElementById('search').value.toLowerCase();
    const projects = document.getElementById('projects').getElementsByTagName('li');
    for (let i = 0; i < projects.length; i++) {
        const project = projects[i].textContent.toLowerCase();
        projects[i].style.display = project.includes(query) ? '' : 'none';
    }
}