<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    /* Add your styling here */
    #gifContainer {
      cursor: pointer;
    }
  </style>
  <script>
    // JavaScript code to capture click event
    document.addEventListener('DOMContentLoaded', function () {
      // Get the GIF container element
      var gifContainer = document.getElementById('gifContainer');

      // Add a click event listener to the container
      gifContainer.addEventListener('click', function () {
        // Replace this with your desired action on click
        alert('GIF clicked!');
      });
    });
  </script>
</head>
<body>
  <!-- HTML structure with a GIF container -->
  <div id="gifContainer">
    <!-- Replace the source with your GIF URL -->
    <img src="your_gif_url_here.gif" alt="GIF">
    inpu
  </div>
</body>
</html>
