
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="./index.php">Mon marché</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-link <?=str_contains($_SERVER['REQUEST_URI'],"/index.php") ? "active" : "" ?>" href="./index.php">Home</a>
          <a class="nav-link <?=str_contains($_SERVER['REQUEST_URI'],"/recap.php") ? "active" : "" ?>" href="./recap.php">Recap</a>
        </div>
      </div>
    </div>
  </nav>