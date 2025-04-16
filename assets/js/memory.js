document.addEventListener('DOMContentLoaded', () => {
    const cardsArray = [
        { name: 'adn', img: '/build/images/adn.png' },
        { name: 'atome', img: '/build/images/atome.png' },
        { name: 'chimiste', img: '/build/images/chimiste.png' },
        { name: 'time', img: '/build/images/time.png' },
        { name: 'LL', img: '/build/images/LL.png' },
        { name: 'LLAN', img: '/build/images/LLAN.png' },
    ];

    let gameGrid = cardsArray.concat(cardsArray).sort(() => 0.5 - Math.random());

    const game = document.getElementById('memory-game');
    gameGrid.forEach(item => {
        const card = document.createElement('div');
        card.classList.add('memory-card');
        card.dataset.name = item.name;

        const front = document.createElement('div');
        front.classList.add('front-face');
        front.style.backgroundImage = `url(${item.img})`;

        const back = document.createElement('div');
        back.classList.add('back-face');
        back.textContent = '?';

        game.appendChild(card);
        card.appendChild(front);
        card.appendChild(back);
    });

    let firstCard = '', secondCard = '';
    let count = 0;
    let previousTarget = null;
    let delay = 1200;

    const match = () => {
        let selected = document.querySelectorAll('.selected');
        selected.forEach(card => {
            card.classList.add('match');
        });
    };

    const resetGuesses = () => {
        firstCard = '';
        secondCard = '';
        count = 0;
        previousTarget = null;

        let selected = document.querySelectorAll('.selected');
        selected.forEach(card => {
            card.classList.remove('selected');
        });
    };

    game.addEventListener('click', function(event) {
        let clicked = event.target;

        if (
            clicked.nodeName === 'SECTION' ||
            clicked === previousTarget ||
            clicked.parentNode.classList.contains('selected') ||
            clicked.parentNode.classList.contains('match')
        ) {
            return;
        }

        if (count < 2) {
            count++;
            if (count === 1) {
                firstCard = clicked.parentNode.dataset.name;
                clicked.parentNode.classList.add('selected');
            } else {
                secondCard = clicked.parentNode.dataset.name;
                clicked.parentNode.classList.add('selected');
            }

            if (firstCard && secondCard) {
                if (firstCard === secondCard) {
                    setTimeout(match, delay);
                }
                setTimeout(resetGuesses, delay);
            }
            previousTarget = clicked;
        }
    });
});
