<footer class="<?php echo $class ?? 'home'; ?>">
  Harvi <?php echo VERSION_NUMBER; ?>
</footer>

</body>
</html>

<?php
  db_disconnect($db);
?>
