<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="aviso.css">
</head>
<body>
    <img src="" alt="">
    
    <h2>Parabéns por se cadastrar!</h2>
    <p>Em breve entraremos em contato por e-mail para que possa acessar nosso site por meio do login.</p>
    <p>Até mais!</p>
    <br><br><br>
    <a href="home.php"><button type="submit" class="button">Voltar</button></a>
</body>

<script>
    // Gera confetes coloridos aleatórios
    const colors = ['#ff4757', '#1e90ff', '#2ed573', '#ffa502', '#eccc68', '#70a1ff'];
    for (let i = 0; i < 100; i++) {
        let confetti = document.createElement('div');
        confetti.classList.add('confetti');
        confetti.style.left = Math.random() * 100 + 'vw';
        confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
        confetti.style.animationDuration = 3 + Math.random() * 2 + 's';
        confetti.style.opacity = Math.random();
        confetti.style.transform = `rotate(${Math.random() * 360}deg)`;
        document.body.appendChild(confetti);
    }
</script>

</html>