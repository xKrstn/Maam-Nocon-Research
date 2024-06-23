  </div>
</div>
  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="include/admin.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
        var buttons = document.querySelectorAll(".book");
        buttons.forEach(function(button) {
            button.addEventListener("click", function() {
                var timeslot = this.getAttribute("data-timeslot");
                document.getElementById("timeslot").value = timeslot;
                document.querySelector(".slot").textContent = timeslot;
            });
        });
    });
  </script>
  <script>
    $(document).ready(function(){
      $('#washid').change(function(){
        var Stdid = $('#washid').val();
        var vechid = $('#vid').val();

        $.ajax({
          type: 'POST',
          url: 'fetch.php',
          data: {wid:Stdid,vid:vechid},
          success: function(data)
          {
            console.log(data);
            $('#show').html(data);
          }
        });
      });
    });
  </script>
</body>

</html>