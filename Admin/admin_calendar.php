<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>




<div id="calendar"></div>
<div id="eventFormContainer" style="display: none;">
    <form id="eventForm">
        <label>Event Name:</label>
        <input type="text" name="eventName" placeholder="Event name">
        <label>Event Start:</label>
        <input type="text" name="eventStartDate" id="eventStartDate">
        <label>Event End:</label>
        <input type="text" name="eventEndDate" id="eventEndDate">
        <button type="submit" id="event_button">Add Event</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    firstDay: 1, // Pirmdiena
    selectable: true,
    select: function(info) {
      var startDate = info.startStr;
      var endDate = info.endStr; // Šeit iegūstam beigu datumu  -------!!!!!!!!!!!------
      $('#eventStartDate').val(startDate);
      $('#eventEndDate').val(endDate); // Sākuma datums un beigu datums ir vienādi
      $('#eventFormContainer').show();
    },
    selectAllow: function(selectInfo) {
      // Atjauno sākuma un beigu datumu vērtības, ja ir izvēlēti vairāki datumu diapazoni
      if (selectInfo.startStr !== selectInfo.endStr) {
        $('#eventStartDate').val(selectInfo.startStr);
        $('#eventEndDate').val(selectInfo.endStr);
      }
      return true; // Atļauj izvēlēties datumu diapazonu
    }
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



  $('#eventForm').submit(function(event) {
    event.preventDefault();
    
    var eventData = $(this).serialize();

    $.ajax({
      type: 'POST',
      url: 'Admin/set_events.php',
      data: eventData,
      success: function(response) {
        alert('Event added successfully!');
        location.reload();
        $('#eventFormContainer').hide();
        // Atjauno kalendāru, lai parādītu jauno notikumu
        calendar.refetchEvents();
       
      },
      error: function(xhr, status, error) {
        console.error('Error adding event:', error);
      }
    });
  });


</script>