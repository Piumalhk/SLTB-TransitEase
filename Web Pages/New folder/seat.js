document.addEventListener("DOMContentLoaded", function() {
    const busSeatsContainer = document.getElementById('bus-seats');
    const totalSeats = 54;

    for (let i = 0; i < totalSeats; i++) {
        const seat = document.createElement('div');
        seat.classList.add('seat', 'available');
        seat.addEventListener('click', handleSeatClick);
        busSeatsContainer.appendChild(seat);
    }

    function handleSeatClick(event) {
        const seat = event.target;

        if (seat.classList.contains('booked')) {
            alert("This seat is already booked.");
            return;
        }

        if (seat.classList.contains('available')) {
            seat.classList.remove('available');
            seat.classList.add('processing');
        } else if (seat.classList.contains('processing')) {
            seat.classList.remove('processing');
            seat.classList.add('counter');
        } else if (seat.classList.contains('counter')) {
            seat.classList.remove('counter');
            seat.classList.add('booked');
        }
    }
});