const date = new Date();

const readCalendar = () => {
    date.setDate(1);
    const monthDays = document.querySelector('.days');
    const lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0).getDate();
    const firstDayIndex = date.getDay();
    const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

    document.querySelector(".date h1").innerHTML = months[date.getMonth()] + "   " + date.getFullYear();
    document.querySelector(".date p").innerHTML = new Date().toDateString();

    let days = "";
    for (let i = firstDayIndex; i > 0; i--) {
        days += `<div></div>`;
    }
    for (let j = 1; j <= lastDay; j++) {
        if (j === new Date().getDate() && date.getMonth() === new Date().getMonth() && date.getFullYear() === new Date().getFullYear()) {
            days += `<div   data-date=" ${createDate(date.getFullYear(), date.getMonth() + 1, j)} " class="today day" >${j}</div>`;
        } else {
            days += `<div   data-date=" ${createDate(date.getFullYear(), date.getMonth() + 1, j)} "  class="day" >${j}</div>`;
        }
    }
    monthDays.innerHTML = days;

};
document.querySelector(".next").addEventListener('click', () => {
    date.setMonth(date.getMonth() + 1);
    readCalendar();
    sendDate();
});
document.querySelector(".prev").addEventListener('click', () => {
    date.setMonth(date.getMonth() - 1);
    readCalendar();
    sendDate();
});

readCalendar();
sendDate();


function createDate(year, month, day) {
    if (month < 10) {
        month = "0" + month;
    }
    if (day < 10) {
        day = "0" + day;
    }
    return year + "-" + month + "-" + day;
}


let bookDate = createDate(date.getFullYear(), date.getMonth(), date.getDate());

function sendDate() {
    document.querySelectorAll('.day').forEach(item => {
        item.addEventListener('click', () => {
            bookDate = item.getAttribute('data-date');
            sendParamsGet(bookDate.toString());
        })
    })
}

function sendParamsGet(dateParam) {

    axios({
        method: 'get',
        url: '/bookings',
        params: {
            date: dateParam,
        }
    }).then(function (response) {
        console.log(response,dateParam);
    //     showBookings(response.data,dateParam);
    })
}

function showBookings(bookings, date){

    if(bookings.length === 0){
        document.getElementById('bookings').innerHTML="No bookings"
    }else{
        for(let booking in bookings){
            document.getElementById('bookings').innerHTML +=

              '  <div class="booking"> <p class="name">${booking.name}</p> <p class="location">${booking.location}</p> </div>'
        }
    }
}

