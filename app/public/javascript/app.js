const date = new Date();

const readCalendar = () => {
    date.setDate(1);
    const monthDays = document.querySelector('.days');
    const lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0).getDate();
    const prevLastDay = new Date(date.getFullYear(), date.getMonth(), 0).getDate();
    const firstDayIndex = date.getDay();
    const lastDayIndex = new Date(date.getFullYear(), date.getMonth() + 1,0).getDay();
    const nextDays = 7 - lastDayIndex;
    const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    document.querySelector(".date h1").innerHTML = months[date.getMonth()] + "   " + date.getFullYear();
    document.querySelector(".date p").innerHTML = new Date().toDateString();
    let days = "";
    for (let i = firstDayIndex; i > 0; i--) {
        days += `<div class="prev-date">${prevLastDay - i + 1}</div>`;
    }
    for (let j = 1; j <= lastDay; j++) {
        if (j === new Date().getDate() && date.getMonth() === new Date().getMonth() && date.getFullYear() === new Date().getFullYear()) {
            days += `<div data-date=" ${createDate(date.getFullYear(), date.getMonth() + 1, j)} " class="today" onclick="getDate()">${j}</div>`;
        } else {
            days += `<div data-date=" ${createDate(date.getFullYear(), date.getMonth() + 1, j)} "  class="days" onclick="getDate()">${j}</div>`;
        }
    }
    for (let k = 1; k <= nextDays; k++) {
        days += `<div class="next-date">${k}</div>`;
        monthDays.innerHTML = days;
    }
};
document.querySelector(".next").addEventListener('click', () => {
    date.setMonth(date.getMonth() + 1);
    readCalendar();
});
document.querySelector(".prev").addEventListener('click', () => {
    date.setMonth(date.getMonth() - 1);
    readCalendar();
});

readCalendar();

function createDate(year, month, day) {
    if (month < 10) {
        month = "0" + month;
    }
    if (day < 10) {
        day = "0" + day;
    }
    return year + "-" + month + "-" + day;
}

let reservDate=createDate(date.getFullYear(),date.getMonth()+1,date.getDay())

function getDate() {
    document.querySelector('.days').forEach(item => {
        item.addEventListener('click', () => {
            reservDate = item.getAttribute('data-date');

            let params = new URLSearchParams();
            params.append('reservDate', reservDate);
            console.log(params);
            axios.post('/reserv.php', params).then(response => {
                console.log(response);
            });
        })
    });
}