


<nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="margin:24px 0;">
    <a class="navbar-brand" href="index.php">Vertaisverkkokauppa</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navb">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navb">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="registerform.php">Register</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="login.php">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="javascript:void(0)">Browse</a>
            </li>
        </ul>
        <form action="search.php" method="post">
            <input class="form-control mr-sm-2" type="text" name="search" placeholder="Search">
            <button class="btn btn-success my-2 my-sm-0" type="submit" name="submit" value="Search">Search</button>
        </form>
    </div>
</nav>