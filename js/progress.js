const fileInput = document.getElementById('fileUpload');
const fileList = document.getElementById('fileList');
let filesArray = [];

fileInput.addEventListener('change', function (event) {
    const files = event.target.files;
    for (let i = 0; i < files.length; i++) {
        filesArray.push(files[i]);
        const li = document.createElement('li');
        li.textContent = files[i].name;
        fileList.appendChild(li);
    }
    fileInput.value = '';
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
    } else {
        const formData = new FormData();
        filesArray.forEach((file, _) => {
            formData.append('fileUpload[]', file);
        });
        formData.append('reportTitle', title);
        formData.append('currentProgress', progress);
        formData.append('nextWeekPlan', nextWeekPlan);
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'submitProgress.php', true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                console.log('Success:', xhr.responseText);
            } else {
                console.log('Error:', xhr.status);
            }
        };
        xhr.send(formData);
        event.preventDefault();
    }
});
