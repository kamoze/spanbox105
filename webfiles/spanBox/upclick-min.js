<script type="text/javascript">

   var uploader = document.getElementById('uploader');

   upclick(
     {
      element: uploader,
      action: '/path_to/you_server_script.php', 
      onstart:
        function(filename)
        {
          alert('Start upload: '+filename);
        },
      oncomplete:
        function(response_data) 
        {
          alert(response_data);
        }
     });

</script>
