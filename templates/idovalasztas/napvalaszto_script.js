let tartalom=JSON.parse('{$params['dates']}');


let dates=[];
if(tartalom.length!=0)
{
    for(let i in tartalom){
        dates.push(new Date(tartalom[i].date));
        console.log(tartalom[i].date);
    }
}
function back() {
    window.location.href='temavalasztas?tanar={$params['username']}';
}
function next() {
    if(selectedDate!=null){
        window.location.href='idovalasztas?tanar={$params['username']}&theme={$params['theme']}&date='+formatDate(selectedDate);
    }
    else{
        alert('Válassz dátumot!')
    }
}

const calendarContainer = document.getElementById('calendarContainer');
const yearSelect = document.getElementById('year');
const monthSelect = document.getElementById('month');
const prevMonthButton = document.getElementById('prevMonthButton');
const nextMonthButton = document.getElementById('nextMonthButton');

const availableDates=dates;

let selectedDate = null;
let selectedCell = null;

function populateDropdowns() {
    const currentYear = new Date().getFullYear();
    for (let year = currentYear - 10; year <= currentYear + 10; year++) {
        const option = document.createElement('option');
        option.value = year;
        option.textContent = year;
        if (year === currentYear) {
            option.selected = true;
        }
        yearSelect.appendChild(option);
    }

    const months = ['Január', 'Február', 'Március', 'Április', 'Május', 'Június', 'Július', 'Augusztus', 'Szeptember', 'Október', 'November', 'December'];
    for (let i = 0; i < months.length; i++) {
        const option = document.createElement('option');
        option.value = i + 1;
        option.textContent = months[i];
        if (i === new Date().getMonth()) {
            option.selected = true;
        }
        monthSelect.appendChild(option);
    }
}

function generateCalendar(year, month) {
    const daysInMonth = new Date(year, month, 0).getDate();
    const firstDay = new Date(year, month - 1, 1).getDay();

    const calendarTable = document.createElement('table');
    calendarTable.className = 'calendar';

    const headerRow = calendarTable.insertRow();
    const daysOfWeek = ['Vas', 'Hét', 'Ked', 'Sze', 'Csü', 'Pén', 'Szo'];
    daysOfWeek.forEach(day => {
        const cell = headerRow.insertCell();
    cell.textContent = day;
});

    let dayCounter = 1;

    for (let row = 0; row < 6; row++) {
        const newRow = calendarTable.insertRow();

        for (let col = 0; col < 7; col++) {
            if (row === 0 && col < firstDay) {
                newRow.insertCell();
            } else if (dayCounter <= daysInMonth) {
                const cell = newRow.insertCell();
                cell.textContent = dayCounter;

                const today = new Date();
                if (year === today.getFullYear() && month === today.getMonth() + 1 && dayCounter === today.getDate()) {
                    cell.classList.add('today');
                }

                dayCounter++;
            }
        }
    }

    calendarContainer.innerHTML = '';
    calendarContainer.appendChild(calendarTable);
}
function formatDate(date) {
    let year = date.getFullYear();
    let month = String(date.getMonth() + 1).padStart(2, '0');
    let day = String(date.getDate()).padStart(2, '0');

    return year+'.'+month+'.'+day;
}

function handleDateSelection(event) {
    if (selectedCell) {
        selectedCell.classList.remove('selected');
        selectedDate=null;
    }

    selectedCell = event.target;
    if (selectedCell.tagName === 'TD' && !selectedCell.classList.contains('disabled')) {
        selectedCell.classList.add('selected');

        const day = parseInt(selectedCell.textContent);
        const year = parseInt(yearSelect.value);
        const month = parseInt(monthSelect.value);
        selectedDate = new Date(year, month - 1, day);
        console.log(formatDate(selectedDate));
    }
}

function disableUnselectableDates(year, month) {
    const cells = calendarContainer.querySelectorAll('td');
    cells.forEach(cell => {
        const day = parseInt(cell.textContent);
    const currentDate = new Date(year, month - 1, day);
    if (availableDates.some(date => isSameDate(currentDate, date))) {
        cell.classList.remove('disabled');
    } else {
        cell.classList.add('disabled');
        if (cell.classList.contains('selected')) {
            cell.classList.remove('selected');
            selectedCell = null;
            selectedDate = null;
        }
    }
});
}

function isSameDate(date1, date2) {
    return (
        date1.getFullYear() === date2.getFullYear() &&
        date1.getMonth() === date2.getMonth() &&
        date1.getDate() === date2.getDate()
    );
}

function updateCalendar(year, month) {
    generateCalendar(year, month);
    disableUnselectableDates(year, month);
}

yearSelect.addEventListener('change', () => {
    const year = parseInt(yearSelect.value);
const month = parseInt(monthSelect.value);
updateCalendar(year, month);
});

monthSelect.addEventListener('change', () => {
    const year = parseInt(yearSelect.value);
const month = parseInt(monthSelect.value);
updateCalendar(year, month);
});

prevMonthButton.addEventListener('click', () => {
    const currentYear = parseInt(yearSelect.value);
const currentMonth = parseInt(monthSelect.value);
if (currentMonth === 1) {
    yearSelect.value = currentYear - 1;
    monthSelect.value = 12;
} else {
    monthSelect.value = currentMonth - 1;
}
updateCalendar(parseInt(yearSelect.value), parseInt(monthSelect.value));
});

nextMonthButton.addEventListener('click', () => {
    const currentYear = parseInt(yearSelect.value);
const currentMonth = parseInt(monthSelect.value);
if (currentMonth === 12) {
    yearSelect.value = currentYear + 1;
    monthSelect.value = 1;
} else {
    monthSelect.value = currentMonth + 1;
}
updateCalendar(parseInt(yearSelect.value), parseInt(monthSelect.value));
});

calendarContainer.addEventListener('click', handleDateSelection);

populateDropdowns();
updateCalendar(new Date().getFullYear(), new Date().getMonth() + 1);

