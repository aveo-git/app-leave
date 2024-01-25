<div class="calendar-container">
  <div id="color-calendar"></div>
</div>

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.2/dist/locale/fr.js"></script>

<script>
  var leaves = <?= $leaves ?>;
  const events = leaves.map(leave => {
    const title = `Abs. ${leave?.u_prenom}`;
    const start = new Date(leave?.l_dateDepart.split(' ')[0]);
    const end = new Date(leave?.l_dateFin.split(' ')[0]);
    return {
      title,
      start,
      end
    };
  });

  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('color-calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      locale: 'fr',
      buttonText: {
        today: 'Aujourd\'hui'
      },
      displayEventTime: false,
      events,
      eventDidMount: function(info) {
        var eventColor = generateEventColor(info.event.title);
        info.el.style.backgroundColor = eventColor;
      }
    });
    calendar.render();

    // Generate a consistent color based on the event title
    function generateEventColor(title) {
      var hash = 0;
      for (var i = 0; i < title.length; i++) {
        hash = title.charCodeAt(i) + ((hash << 5) - hash);
      }
      var colorIndex = Math.abs(hash) % 5;
      var colors = ['#4d40c7', '#33b5b4', '#df9f15', '#d75454', '#5ed14e', '#b777e9', '#e977d7', '#a8cd30'];
      return colors[colorIndex];
    }
  });
</script>