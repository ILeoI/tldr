function hideAllTasks()
{
    for (let i = 0; i < 8; i++)
    {
        let task = document.getElementById("task" + (i+1));
        if (!task.classList.contains("hidden"))
        {
            task.classList.add("hidden");
        }
    }
}

function changeTasks()
{
    hideAllTasks();
    const currentTask = document.getElementById("task-selector").value;
    const task = document.getElementById("task" + currentTask);
    task.classList.remove("hidden");
}

function init()
{
    changeTasks();
}

init();
