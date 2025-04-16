// Variables pour Matter.js
let Engine = Matter.Engine,
    World = Matter.World,
    Bodies = Matter.Bodies,
    Body = Matter.Body;

let engine;
let world;
let cellule;

function setup() {
    createCanvas(800, 600);

    // Initialisation de Matter.js
    engine = Engine.create();
    world = engine.world;

    // Créer une cellule (un simple cercle avec des propriétés physiques)
    let celluleOptions = {
        restitution: 0.5, // Bouncing factor
        friction: 0.01,
        frictionAir: 0.05
    };
    cellule = Bodies.circle(400, 300, 20, celluleOptions);
    World.add(world, cellule);

    // Sol (afin que la cellule ne tombe pas en dehors de la scène)
    let ground = Bodies.rectangle(400, height, 810, 10, { isStatic: true });
    World.add(world, ground);
}

function draw() {
    background(51);

    // Mettre à jour le moteur Matter.js
    Engine.update(engine);

    // Dessiner la cellule
    fill(127);
    ellipse(cellule.position.x, cellule.position.y, 40, 40);
}

// Fonction pour appliquer des forces à la cellule
function keyPressed() {
    if (keyCode === UP_ARROW) {
        Body.applyForce(cellule, cellule.position, { x: 0, y: -0.05 });
    } else if (keyCode === RIGHT_ARROW) {
        Body.applyForce(cellule, cellule.position, { x: 0.05, y: 0 });
    } else if (keyCode === LEFT_ARROW) {
        Body.applyForce(cellule, cellule.position, { x: -0.05, y: 0 });
    } else if (keyCode === DOWN_ARROW) {
        Body.applyForce(cellule, cellule.position, { x: 0, y: 0.05 });
    }
}

function saveCelluleState(state) {
    fetch('/save-cellule', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(state)
    }).then(response => response.json())
        .then(data => console.log(data));
}

