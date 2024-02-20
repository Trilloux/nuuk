<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>

<div id="calendar"></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    firstDay: 1, // Pirmdiena
    selectable: true
  });
  calendar.render();

  $.ajax({
    url: 'Admin/get_events.php',
    type: 'GET',
    dataType: 'json',
    success: function(response) {
      if (response.status) {
        var events = response.data.map(function(event) {
          return {
            id: event.id,
            title: event.title,
            start: event.start,
            end: event.end
          };
        });
        calendar.addEventSource(events);
        calendar.render();
      } else {
        console.error('Kļūda iegūstot notikumu datus:', response.msg);
      }
    },
    error: function(xhr, status, error) {
      console.error('Kļūda iegūstot notikumu datus:', error);
    }
  });
});
</script>
