document.addEventListener("DOMContentLoaded", function() {
    let tasks = [

    ];

    if(tasks.length>0) {
        let gantt = new Gantt("#gantt", tasks, {
            view_mode: 'Month',
            custom_popup_html: function (task) {
                return `
                <div class="details-container">
                    <h5>${task.name}</h5>
                    <p>Objective: ${task.objective}</p>
                    <p>Start: ${task.start}</p>
                    <p>End: ${task.end}</p>
                    <p>Progress: ${task.progress}%</p>
                </div>
            `;
            },
            on_date_change: function (task, start, end) {
                console.log(task, start, end);
                alert(`Date of task ${task.name} changed to: ${start} - ${end}`);
            },
            on_progress_change: function (task, progress) {
                console.log(task, progress);
                alert(`Progress of task ${task.name} changed to: ${progress}%`);
            }
        });
    }

    const addTaskButton = document.getElementById('add-task-button');
    const taskForm = document.getElementById('task-form');
    const submitTaskButton = document.getElementById('submit-task-button');
    const closeTaskButton = document.getElementById('close-task-button');

    addTaskButton.addEventListener('click', () => {
        taskForm.style.display = 'block';
    });
    closeTaskButton.addEventListener('click', () => {
        taskForm.style.display = 'none';
    });


    submitTaskButton.addEventListener('click', (event) => {
        event.preventDefault(); // 防止表單默認提交行為

        const taskName = document.getElementById('task-name').value;
        const taskStart = document.getElementById('task-start').value;
        const taskEnd = document.getElementById('task-end').value;
        const taskProgress = document.getElementById('task-progress').value;
        const taskObjective = document.getElementById('task-objective').value;

        if (taskName && taskStart && taskEnd && taskProgress && taskObjective) {
            const newTask = {
                id: `Task ${tasks.length + 1}`,
                name: taskName,
                start: taskStart,
                end: taskEnd,
                progress: taskProgress,
                custom_class: 'custom-task',
                objective: taskObjective
            };

            tasks.push(newTask);

            // 清除並重新渲染甘特圖
            document.getElementById('gantt').innerHTML = '';
            gantt = new Gantt("#gantt", tasks, {
                view_mode: 'Month',
                custom_popup_html: function(task) {
                    return `
                        <div class="details-container">
                            <h5>名稱 : ${task.name}</h5>
                            <p>目標 : ${task.objective}</p>
                            <p>開始時間: ${task.start}</p>
                            <p>結束時間: ${task.end}</p>
                            <p>進度: ${task.progress}%</p>
                        </div>
                    `;
                },
                on_date_change: function(task, start, end) {
                    console.log(task, start, end);
                },
                on_progress_change: function(task, progress) {
                    console.log(task, progress);
                }
            });

            taskForm.style.display = 'none';
            taskForm.reset();
        } else {
            alert('請填寫所有字段');
        }
    });
});
