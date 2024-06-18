document.getElementById('fileUpload').addEventListener('change', function (event) {
    const fileList = document.getElementById('fileList');
    fileList.innerHTML = '';

    const files = event.target.files;
    for (let i = 0; i < files.length; i++) {
        const li = document.createElement('li');
        li.textContent = files[i].name;
        fileList.appendChild(li);
    }
});

document.getElementById('progressForm').addEventListener('submit', function (event) {
    let valid = true;
    const title = document.getElementById('reportTitle').value.trim();
    const progress = document.getElementById('currentProgress').value.trim();
    const nextWeekPlan = document.getElementById('nextWeekPlan').value.trim();

    if (!title) {
        document.getElementById('titleError').style.display = 'block';
        valid = false;
    } else {
        document.getElementById('titleError').style.display = 'none';
    }

    if (!progress) {
        document.getElementById('progressError').style.display = 'block';
        valid = false;
    } else {
        document.getElementById('progressError').style.display = 'none';
    }

    if (!nextWeekPlan) {
        document.getElementById('nextWeekError').style.display = 'block';
        valid = false;
    } else {
        document.getElementById('nextWeekError').style.display = 'none';
    }

    if (!valid) {
        event.preventDefault();
    }
});
