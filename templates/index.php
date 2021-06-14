<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito">
    <link rel="stylesheet" href="styles/main.css" />
    <title>Navarik Zoo</title>
</head>
<body>
    <div class="header">
        <h1>Zoo is open</h1>
        <div class="time">
            Time at the zoo:
            <span><?php echo $time; ?></span>
        </div>
    </div>
    <div class="animal-group giraffe">
        <div class="description">
            Giraffes <span>Giraffes die at 50%</span>
        </div>
        <ul>
            <?php foreach( $animals['giraffes'] as $giraffe ): ?>
            <li>
                <img src="<?php echo $giraffe->isAlive ? 'images/giraffe.svg' : 'images/rip.svg'; ?>" alt="Giraffe Icon" />
                <span class="hp-amount"><?php echo number_format($giraffe->health, 1, '.', ',') ?> %</span>
                <div class="hp-bar">
                    <i class="hp-foreground hp-<?php echo $giraffe->hpColor ?>" aria-hidden="true" style="width: <?php echo $giraffe->health ?>%"></i>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>  
    </div>
    <div class="animal-group monkey">
        <div class="description">
            Monkeys <span>Monkeys die at 30%</span>
        </div>
        <ul>
            <?php foreach( $animals['monkeys'] as $monkey ): ?>
            <li>
                <img src="<?php echo $monkey->isAlive ? 'images/monkey.svg' : 'images/rip.svg'; ?>" alt="Monkey Icon" />
                <span class="hp-amount"><?php echo number_format($monkey->health, 1, '.', ',') ?> %</span>
                <div class="hp-bar">
                    <i class="hp-foreground hp-<?php echo $monkey->hpColor ?>" aria-hidden="true" style="width: <?php echo $monkey->health ?>%"></i>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>  
    </div>
    <div class="animal-group elephant">
        <div class="description">
            Elephants
            <span>Elephants die if can’t walk for an hour and stop walking at 70%</span>
        </div>
        <ul>
            <?php foreach( $animals['elephants'] as $elephant ): ?>
            <li>
                <img src="<?php echo $elephant->isAlive ? 'images/elephant.svg' : 'images/rip.svg'; ?>" alt="Elephant Icon" />
                <span class="hp-amount"><?php echo number_format($elephant->health, 1, '.', ',') ?> %</span>
                <div class="hp-bar">
                    <i class="hp-foreground hp-<?php echo $elephant->hpColor ?>" aria-hidden="true" style="width: <?php echo $elephant->health ?>%"></i>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>  
    </div>

    <div class="btn-container">
        <input type="button" class="button-primary" onclick="location.href='?action=feed';" value="Feed animals" />
        <input type="button" class="button-secondary" onclick="location.href='?action=age';" value="Pass one hour" />
        <input type="button" class="button-close" title="Destroys session to test Zoo again =)" onclick="location.href='?action=close';" value="Close the Zoo" />
    </div>
</body>
</html>