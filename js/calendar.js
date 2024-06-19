document.addEventListener('DOMContentLoaded', () => {
    const calendar = document.getElementById('calendar');
    const monthYearDisplay = document.getElementById('monthYear');
    const daysContainer = document.querySelector('.days');
    const detailsContent = document.getElementById('detailsContent');

    let currentDate = new Date();
    let events = {};

    function fetchEvents() {
        fetch('./events.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                events = data.reduce((acc, event) => {
                    const eventDate = new Date(event.date);
                    const formattedDate = `${eventDate.getFullYear()}-${String(eventDate.getMonth() + 1).padStart(2, '0')}-${String(eventDate.getDate()).padStart(2, '0')}`;
                    acc[formattedDate + '0'] = event.description;
                    acc[formattedDate + '1'] = event.pass;
                    return acc;
                }, {});
                renderCalendar(currentDate);
            })
            .catch(error => console.error('There was a problem with the fetch operation:', error));
    }

    function renderCalendar(date) {
        daysContainer.innerHTML = '';
        const year = date.getFullYear();
        const month = date.getMonth();
        const firstDayOfMonth = new Date(year, month, 1).getDay();
        const lastDateOfMonth = new Date(year, month + 1, 0).getDate();

        monthYearDisplay.textContent = `${date.toLocaleString('default', { month: 'long' })} ${year}`;

        for (let i = 1; i <= firstDayOfMonth; i++) {
            const dayDiv = document.createElement('div');
            dayDiv.classList.add('day');
            daysContainer.appendChild(dayDiv);
        }

        for (let i = 1; i <= lastDateOfMonth; i++) {
            const dayDiv = document.createElement('div');
            dayDiv.classList.add('day');
            dayDiv.textContent = i;
            const eventDate = `${year}-${String(month + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;

            if (events[eventDate + '0']) {
                const marker = document.createElement('div');
                if (events[eventDate + '1'] === '1') {
                    marker.classList.add('marker');
                    dayDiv.addEventListener('click', () => showDetails(eventDate, events[eventDate + '0'], 'true'));
                } else {
                    marker.classList.add('marker2');
                    dayDiv.addEventListener('click', () => showDetails(eventDate, events[eventDate + '0'], 'false'));
                }
                dayDiv.appendChild(marker);
            } else {
                dayDiv.addEventListener('click', () => showDetails(eventDate, 'No events', ''));
            }
            daysContainer.appendChild(dayDiv);
        }
    }

    function showDetails(date, details, pass) {
        let adr = '';
        if (pass === 'false') adr = "(未評分)";
        if (pass === 'true') adr = "(已評分)";
        detailsContent.textContent = `[${date}]: ${details} ${adr}`;
    }

    calendar.addEventListener('wheel', (event) => {
        if (event.deltaY < 0) {
            currentDate.setMonth(currentDate.getMonth() - 1);
        } else {
            currentDate.setMonth(currentDate.getMonth() + 1);
        }
        renderCalendar(currentDate);
    });

    fetchEvents();
});
