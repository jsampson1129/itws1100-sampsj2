$(document).ready(function () {
  $.ajax({
    url: '/iit/projects.json',
    dataType: 'json',
    success: function (data) {
      $('#loading').fadeOut(500);

      const $list = $('#projects-list');

      $.each(data.projects, function (i, project) {
        const $li = $('<li>').addClass('project-item ui-state-default');

        const $link = $('<a>')
          .attr('href', project.url)
          .attr('target', '_blank')
          .text(project.title);

        const $desc = $('<p>')
          .addClass('description')
          .text(project.description);

        $li.append($link).append($desc);

       
        $li.hide().appendTo($list).slideDown(600).fadeTo(800, 1);
      });

      
      $('#projects-list').sortable({
        axis: 'y',
        containment: 'parent',
        cursor: 'move',
        opacity: 0.7
      });

 
      $('.project-item').hover(
        function () { $(this).addClass('ui-state-highlight'); },
        function () { $(this).removeClass('ui-state-highlight'); }
      );

    },
    error: function () {
      $('#loading').html('<p style="color:red;">Error loading projects.json</p>');
    }
  });
});