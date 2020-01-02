<footer class="<?php echo $class ?? 'home'; ?>">
  &copy; <?php echo date('Y'); ?> Harvi
</footer>

</body>
</html>

<?php
  db_disconnect($db);
?>
