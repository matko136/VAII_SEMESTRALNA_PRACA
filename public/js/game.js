document.addEventListener('touchstart', handleTouchStart, false);
document.addEventListener('touchmove', handleTouchMove, false);

var xDown = null;
var yDown = null;

function getTouches(evt) {
    return evt.touches ||             // browser API
        evt.originalEvent.touches; // jQuery
}

function handleTouchStart(evt) {
    const firstTouch = getTouches(evt)[0];
    xDown = firstTouch.clientX;
    yDown = firstTouch.clientY;
};

function handleTouchMove(evt) {
    if (!xDown || !yDown) {
        return;
    }

    var xUp = evt.touches[0].clientX;
    var yUp = evt.touches[0].clientY;

    var xDiff = xDown - xUp;
    var yDiff = yDown - yUp;

    if (Math.abs(xDiff) > Math.abs(yDiff)) {/*most significant*/
        if (xDiff > 0) {
            /* left swipe */
            moveDirection("left");
        } else {
            /* right swipe */
            moveDirection("right");
        }
    } else {
        if (yDiff > 0) {
            /* up swipe */
            moveDirection("up");
        } else {
            /* down swipe */
            moveDirection("down");
        }
    }
    /* reset values */
    xDown = null;
    yDown = null;
};

//var isReady = document.readyState !== 'complete';
const directions = {
    LEFT: "left",
    UP: "up",
    DOWN: "down",
    RIGHT: "right",
}

class BodyPart {

    constructor(x, y, direction) {
        this.x = x;
        this.y = y;
        this.lastX = x;
        this.lastY = y;
        this.direction = direction;
        this.lastDirection = direction;
    }

    setDirection(direction) {
        this.lastDirection = this.direction;
        this.direction = direction;
    }

    getDirection() {
        return this.direction;
    }

    getX() {
        return this.x;
    }

    getY() {
        return this.y;
    }

    getLastX() {
        return this.lastX;
    }

    getLastY() {
        return this.lastY;
    }

    setLastX() {
        this.lastX = this.x;
    }

    setLastY() {
        this.lastY = this.y;
    }

    getLastDirection() {
        return this.lastDirection;
    }

    setLastDirection(direction) {
        this.lastDirection = direction;
    }

    setX(x) {
        this.lastX = this.x;
        this.x = x;
    }

    setY(y) {
        this.lastY = this.y;
        this.y = y;
    }
}

class Food {
    constructor(x, y) {
        this.x = x;
        this.y = y;
    }

    getX() {
        return this.x;
    }

    getY() {
        return this.y;
    }
}



let width = (($(window).width() * 0.8) - ($(window).width() * 0.8) % 50);
let height = (($(window).height() * 0.8) - ($(window).height() * 0.8) % 50);
let leftt = ($(window).width() - width) / 2;
let topp = ($(window).height() - height) / 2;
let rectSide = 50;
let direction = directions.RIGHT;
let requestedDirection = "non";
let requestedStackDirection = "non";
var c;
var ctx;
var score = 0;
var bodyPartsInt = 5;
var head = new BodyPart(bodyPartsInt * rectSide, 0, directions.RIGHT)
//var x = 5*rectSide;
//var y = 0;
var bodyParts = new Array(bodyPartsInt);
for (i = 0; i < bodyPartsInt; i++) {
    bodyParts[i] = new BodyPart((bodyPartsInt - 1 - i) * rectSide, 0, directions.RIGHT);
}

function isCollision(x1, y1, x2, y2, side) {
    if((x2 >= x1 && x2 <= x1+side) && (y2 >= y1 && y2 <= y1+side))
        return true;
    if(((x2+side) >= x1 && (x2+side) <= x1+side) && (y2 >= y1 && y2 <= y1+side))
        return true;
    if(((x2+side) >= x1 && (x2+side) <= x1+side) && ((y2+side) >= y1 && (y2+side) <= y1+side))
        return true;
    if((x2 >= x1 && x2 <= x1+side) && ((y2+side) >= y1 && (y2+side) <= y1+side))
        return true;
    return false;
}

function isCollidingBody(x,y, side, withoutFirst) {
    var f = 0;
    if(withoutFirst)
        f = 1;
    for(i = f; i < bodyParts.length; i++) {
        if(isCollision(bodyParts[i].getX(), bodyParts[i].getY(), x, y, side))
            return true;
    }
    return false;
}

function isCollidingSnake(x,y, side) {
    if(isCollision(head.getX(), head.getY(), x, y, side))
        return true;
    return isCollidingBody(x,y,side, false);
}

Sscore = null;
ctxScore = null;
c = null;
ctx = null;
var food = null;
document.addEventListener('DOMContentLoaded', () => {


    Sscore = document.getElementById("score");
    ctxScore = Sscore.getContext("2d");
    c = document.getElementById("myCanvas");
    ctx = c.getContext("2d");
    c.style.left = leftt + "px";
    c.style.top = topp + "px";
    c.width = width;
    c.height = height;
    c.style.position = "absolute";
    drawRect(0, 0, c.width, c.height, "white", ctx);
    var speedLabel = document.createElement("label");
    speedLabel.innerHTML = "Choose speed: ";
    speedLabel.setAttribute("style", "z-index:2; position:relative; top:" + (c.height/2) + "px; left:" + ((c.width/2)-70) + "px");
    speedLabel.setAttribute("id", "speedLabel")
    c.parentNode.append(speedLabel);
    var speed = document.createElement("select");
    speed.setAttribute("id", "speed");
    speed.setAttribute("label", "Choose speed: ");
    speed.setAttribute("style", "z-index:2; position:relative; top:" + c.height/2 + "px; left:" + ((c.width/2)-67) + "px");
    speed.innerHTML = `<option value="10">1</option>
<option selected value="9">2</option>
<option value="8">3</option>
<option value="7">4</option>
<option value="6">5</option>
<option value="5">6</option>
<option value="4">7</option>
<option value="3">8</option>
<option value="2">9</option>
<option value="1">10</option>`;

    c.parentNode.append(speed);


    var inputSpeed = document.createElement('input');
    inputSpeed.setAttribute("type", "button");
    inputSpeed.setAttribute("value", "Start!");
    inputSpeed.setAttribute("style", "z-index:2; position:relative; top:" + c.height/2 + "px; left:" + ((c.width/2)-65) + "px");
    inputSpeed.setAttribute("id", "inputSpeed");
    inputSpeed.setAttribute("onclick", "start()");


    $("html").css({
        "touch-action": "pan-down"
    });
    c.parentNode.append(inputSpeed);
    //let lastX = x;
    //let lastY = y;



    //while(true) {
    /*setTimeout(() => { }, 1000);
    ctx.fillStyle = "white";
    ctx.fillRect(0,0,c.width,c.height);
    ctx.fillStyle = "black";
    ctx.fillRect(20,y,50,50);
    y++;*/
    //}
    /*ctx.moveTo(0, 0);
    ctx.lineTo(200, 100);
    ctx.stroke();*/

});

function start() {
    var apple = document.createElement('img');
    var head_left = document.createElement('img');
    var head_up = document.createElement('img');
    var head_down = document.createElement('img');
    var head_right = document.createElement('img');
    head_left.setAttribute("src", "VAII_SEMESTRALNA_PRACA/public/head_left.png");
    head_up.setAttribute("src", "VAII_SEMESTRALNA_PRACA/public/head_up.png");
    head_up.setAttribute("width", "50px");
    head_up.setAttribute("height", "50px");
    head_down.setAttribute("src", "VAII_SEMESTRALNA_PRACA/public/head_down.png");
    head_right.setAttribute("src", "VAII_SEMESTRALNA_PRACA/public/head_right.png");
    apple.setAttribute('id', "apple");
    apple.setAttribute("width", "50px");
    apple.setAttribute("height", "50px");
    apple.setAttribute("src", "VAII_SEMESTRALNA_PRACA/public/apple.png");
    apple.setAttribute("alt", "red apple");
    let speed = document.getElementById("speed").value;
    c.parentNode.removeChild(document.getElementById("speedLabel"));
    c.parentNode.removeChild(document.getElementById("speed"));
    c.parentNode.removeChild(document.getElementById("inputSpeed"));
    var refreshInterval = setInterval(() => {
        drawRect(0, 0, Sscore.width, Sscore.height, "white", ctxScore);
        ctxScore.font = "30px Comic Sans MS";
        ctxScore.fillStyle = "red";
        ctxScore.textAlign = "center";
        ctxScore.fillText("Score: " + score, Sscore.width/2, Sscore.height/2);
        if(food == null) {
            var hX = Math.floor((width-1) / rectSide) + 1;
            var hY = Math.floor((height-1) / rectSide) + 1;
            var randX = 1;
            var randY = 1;
            do {
                randX = Math.floor(Math.random() * hX)*rectSide;
                randY = Math.floor(Math.random() * hY)*rectSide;
            } while (isCollidingSnake(randX+((rectSide-rectSide/1.2)/2), randY+((rectSide-rectSide/1.2)/2), rectSide/1.2));
            food = new Food(randX, randY);
        }
        /*if (Math.abs(head.getX() - bodyParts[0].getX()) > 50 || Math.abs(head.getY() - bodyParts[0].getY()) > 50) {
            var h = 0;
        }*/
        if (requestedDirection !== direction && requestedDirection !== "non" && !oppositesDirections(direction, requestedDirection)) {
            if (isAbleToChange(head.getX(), head.getY(), requestedDirection)) {
                direction = requestedDirection;
                head.setDirection(requestedDirection);
                if (requestedStackDirection !== "non" && requestedStackDirection !== direction) {
                    requestedDirection = requestedStackDirection;
                    requestedStackDirection = "non";
                } else {
                    requestedDirection = "non";
                }
            }
        } else {
            requestedDirection = "non";
            head.setLastDirection(direction);
        }
        drawRect(0, 0, c.width, c.height, "white", ctx);
        //lastX = x;
        //lastY = y;
        moveBodyPart(head, direction, "orange", false);
        switch(head.getDirection()) {
            case "left":
                ctx.drawImage(head_left, head.getX(), head.getY(), 50, 50);
                break;
            case "up":
                ctx.drawImage(head_up, head.getX(), head.getY(), 50, 50);
                break;
            case "down":
                ctx.drawImage(head_down, head.getX(), head.getY(), 50, 50);
                break;
            case "right":
                ctx.drawImage(head_right, head.getX(), head.getY(), 50, 50);
                break;
        }
        //var addNewBody = false;
        if(isCollision(food.getX(), food.getY(), head.getX()+rectSide/4, head.getY()+rectSide/4, rectSide/2)) {
            food = null;
            addNewBodyPart(bodyParts[bodyParts.length-1]);
            score++;
        }

        if(food !== null) {
            ctx.drawImage(apple, food.getX(), food.getY(), 50, 50);
            //drawRect(food.getX(), food.getY(), rectSide, rectSide, "brown", ctx);
        }

        if (bodyParts[0].getDirection() !== head.getLastDirection()) {
            if (bodyParts[0].getX() === head.getLastX() || bodyParts[0].getY() === head.getLastY()) {
                bodyParts[0].setDirection(head.getLastDirection());
            }
        } else {
            bodyParts[0].setLastDirection(head.getLastDirection());
        }
        moveBodyPart(bodyParts[0], bodyParts[0].getDirection(), "green");

        //bodyParts[0].setX(lastX);
        //bodyParts[0].setY(lastY);
        //if()
        for (i = 1; i < bodyParts.length; i++) {
            //bodyParts[i].setX(bodyParts[i-1].getLastX());
            //bodyParts[i].setY(bodyParts[i-1].getLastY());
            if (bodyParts[i].getDirection() !== bodyParts[i - 1].getLastDirection()) {
                if (bodyParts[i].getX() === bodyParts[i - 1].getLastX() || bodyParts[i].getY() === bodyParts[i - 1].getLastY()) {
                    bodyParts[i].setDirection(bodyParts[i - 1].getLastDirection());
                } else {
                    bodyParts[i].setLastDirection(bodyParts[i].getDirection());
                }
            } else {
                bodyParts[i].setLastDirection(bodyParts[i - 1].getLastDirection());
            }
            moveBodyPart(bodyParts[i], bodyParts[i].getDirection(), "green");
        }

        //drawRect(head.getX(), head.getY(), rectSide, rectSide, "orange", ctx);

        if(isCollidingBody(head.getX()+((rectSide-rectSide/1.2)/2), head.getY()+((rectSide-rectSide/1.2)/2), rectSide/1.2, true)) {
            ctx.font = "30px Comic Sans MS";
            ctx.fillStyle = "red";
            ctx.textAlign = "center";
            ctx.fillText("The End :)", c.width/2, c.height/2);
            var input = document.createElement('input');
            input.setAttribute("type", "button");
            input.setAttribute("value", "Start new game!");
            input.setAttribute("style", "z-index:2; position:relative; top:" + c.height/2 + "px; left:" + ((c.width/2)-250) + "px");
            input.setAttribute("id", "restButton");
            input.setAttribute("onclick", "reload()");

            var input2 = document.createElement('input');
            input2.setAttribute("type", "button");
            input2.setAttribute("value", "Write score in score table");
            input2.setAttribute("style", "z-index:2; position:relative; top:" + c.height/2 + "px; left:" + ((c.width/2)-220) + "px");
            input2.setAttribute("id", "addScoreee");
            input2.setAttribute("onclick", "overlay()");

            var input3 = document.createElement('input');
            input3.setAttribute("type", "button");
            input3.setAttribute("value", "Show score table");
            input3.setAttribute("style", "z-index:2; position:relative; top:" + c.height/2 + "px; left:" + ((c.width/2)-190) + "px");
            input3.setAttribute("id", "showScoree");
            input3.setAttribute("onclick", "showScoreTable()");
            //input.innerText = `type="button" style="z-index:2; position:relative; top:${c.height/2}px; left:${c.width/2}px" value="newGame"/`;
            //input.innerHTML = `type="button" style="z-index:2; position:relative; top:${c.height/2}px; left:${c.width/2}px" value="newGame"/`
            c.parentNode.append(input);
            c.parentNode.append(input2);
            c.parentNode.append(input3);
            //c.innerHTML += `<input type="button" style="z-index:2; position:relative; top:${c.height/2}px; left:${c.width/2}px" value="newGame"/>`
            clearInterval(refreshInterval);
        }
        /*if(x == c.width) {
            x = 0;
        } else {
            x++;
        }*/
    }, speed);
}

function addNewBodyPart(bodyPart) {
    var oldX = bodyPart.getX();
    var oldY = bodyPart.getY();
    var newX = 1;
    var newY = 1;
    var newDirection = direction.RIGHT;
    switch (bodyPart.getDirection()) {
        case "left":
            newX = (oldX)%(width-rectSide)
            if(oldX < width-rectSide)
                newX+=rectSide;
            newY = oldY;
            newDirection = directions.LEFT;
            break;
        case "up":
            newY = (oldY)%(height-rectSide)
            if(oldY < height-rectSide)
                newY+=rectSide;
            newX = oldX;
            newDirection = directions.UP;
            break;
        case "down":
            newY = oldY-50;
            if(oldY < rectSide)
                newY = height-(rectSide-oldY);
            newX = oldX;
            newDirection = directions.DOWN;
            break;
        case "right":
            newX = oldX-50;
            if(oldX < rectSide)
                newY = width-(rectSide-oldX);
            newY = oldY;
            newDirection = directions.RIGHT;
            break;
    }
    bodyParts.push(new BodyPart(newX, newY, newDirection));
}

function drawHorizontal(xx, yy, color) {
    drawRect(xx, yy, rectSide, rectSide, color, ctx);
    if (xx > width - rectSide) {
        drawRect(-(width - xx), yy, rectSide, rectSide, color, ctx);
    }
    if (yy > height - rectSide) {
        drawRect(xx, -(height - yy), rectSide, rectSide, color, ctx);
    }
}

function drawVertical(xx, yy, color) {
    drawRect(xx, yy, rectSide, rectSide, color, ctx);
    if (yy > height - rectSide) {
        drawRect(xx, -(height - yy), rectSide, rectSide, color, ctx);
    }
}

function drawRect(xx, yy, width, height, color, ctx) {
    ctx.fillStyle = color;
    ctx.fillRect(xx, yy, width, height);
}

function moveDirection(directionn) {
    switch (directionn) {

        case "left":
            if (requestedDirection === "non") {
                if (direction === directions.LEFT)
                    return;
                if (!oppositesDirections(direction, directions.LEFT))
                    requestedDirection = directions.LEFT;
            } else
                requestedStackDirection = directions.LEFT;
            break;
        case "up":
            if (requestedDirection === "non") {
                if (direction === directions.UP)
                    return;
                if (!oppositesDirections(direction, directions.UP))
                    requestedDirection = directions.UP;
            } else
                requestedStackDirection = directions.UP;
            break;
        case "down":
            if (requestedDirection === "non") {
                if (direction === directions.DOWN)
                    return;
                if (!oppositesDirections(direction, directions.DOWN))
                    requestedDirection = directions.DOWN;
            } else
                requestedStackDirection = directions.DOWN;
            break;
        case "right":
            if (requestedDirection === "non") {
                if (direction === directions.RIGHT)
                    return;
                if (!oppositesDirections(direction, directions.RIGHT)) {
                    requestedDirection = directions.RIGHT;
                }
            } else
                requestedStackDirection = directions.RIGHT;
            break;
    }
}

document.addEventListener('keydown', (e) => {
    if (e.code === "ArrowLeft") {
        moveDirection("left");
    } else if (e.code === "ArrowUp") {
        moveDirection("up");
    } else if (e.code === "ArrowDown") {
        moveDirection("down");
    } else if (e.code === "ArrowRight") {
        moveDirection("right");
    }
});

function oppositesDirections(direction1, direction2) {
    switch (direction1) {
        case "left":
            if (direction2 === "right") return true;
            break;
        case "up":
            if (direction2 === "down") return true;
            break;
        case "down":
            if (direction2 === "up") return true;
            break;
        case "right":
            if (direction2 === "left") return true;
            break;
    }
    return false;
}

function isAbleToChange(x, y, directionn) {
    /*if(x === width || y === height)
        return false;*/
    switch (directionn) {
        case "left":
            if (y % rectSide === 0 && direction !== "right") return true;
            break;
        case "up":
            if (x % rectSide === 0 && direction !== "down") return true;
            break;
        case "down":
            if (x % rectSide === 0 && direction !== "up") return true;
            break;
        case "right":
            if (y % rectSide === 0 && direction !== "left") return true;
            break;
    }
    return false;
}

function moveBodyPart(bodyPart, direction, color, draw=true) {
    let x = bodyPart.getX();
    let y = bodyPart.getY();
    switch (direction) {
        case "left":
            if (x - 5 < 0) bodyPart.setX(width-(5-x));
            else {
                bodyPart.setX(x - 5);
                bodyPart.setLastY();
            }
            if(draw) {
                drawHorizontal(x, y, color);
            }
            break;
        case "up":
            if (y - 5 < 0) bodyPart.setY(height-(5-y));
            else {
                bodyPart.setY(y - 5);
                bodyPart.setLastX();
            }
            if(draw) {
                drawVertical(x, y, color);
            }
            break;
        case "down":
            if (y + 5 > height-1) bodyPart.setY((y+5)-height);
            else {
                bodyPart.setY(y + 5);
                bodyPart.setLastX();
            }
            if(draw) {
                drawVertical(x, y, color);
            }
            break;
        case "right":
            if (x + 5 > c.width-1) bodyPart.setX((x+5)-width);
            else {
                bodyPart.setX(x + 5);
                bodyPart.setLastY();
            }
            if(draw) {
                drawHorizontal(x, y, color);
            }
            break;
    }
}

function reload() {
    location.reload();
}

function addScore() {
    $.ajax({
        type: "post",
        url: "?c=Game&a=addScore",
        data:
            {
                'nickname': document.getElementById("title").value,
                'score': score
            },
        cache: false,
        success: function (msg, status, jqXHR) {
        }
    });
    showScoreTable();
}

async function showScoreTable() {
    var html = `<table class="table table-bordered table-dark"><thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nick</th>
      <th scope="col">Score</th>
    </tr>
  </thead>
<tbody>`;

    let response = await fetch('?c=Game&a=getScore');
    let data = await response.json();
    if(data.length > 0) {
        for(var i = 0; i < data.length; i++) {
            for(var j = data.length-1; j > i; j--) {
                if(data[j].score > data[j-1].score) {
                    var scoree = data[j].score;
                    var nick = data[j].nickname;
                    data[j].score = data[j-1].score;
                    data[j].nickname = data[j-1].nickname;
                    data[j-1].score = scoree;
                    data[j-1].nickname = nick;
                }
            }
            html+=`<tr>
                <th scope="row">${i+1}</th>
                <td>${data[i].nickname}</td>
                <td>${data[i].score}</td>
            </tr>`;
        }
        html+=` </tbody>
                </table>`;
        html += `<input class="film_data" type="button" onclick="cancelOverlay()" value="Cancel" name="overLay_cancel">`;
        if(document.getElementById("indiv") !== null)
            document.getElementById("indiv").innerHTML = html;
        else {
            var over = document.createElement("div");
            over.setAttribute("style", "z-index:2");
            var first = c;//$('#row').children().first();
            var input = document.createElement('div');
            input.setAttribute('id', 'indiv');
            input.innerHTML = html;
            over.setAttribute('class', 'overlay');
            over.setAttribute('id', "overlay");
            over.appendChild(input);
            c.parentNode.insertBefore(over, first);
            var inp2 = document.createElement('div');
            inp2.setAttribute('id', "overlayback");
            over.insertBefore(inp2, input);
        }
    }
}

function overlay() {
    var over = document.createElement("div");
    over.setAttribute("style", "z-index:2");
    var first = c;//$('#row').children().first();
    var input = document.createElement('div');
    input.setAttribute('id', 'indiv');
    var html = `<div id="film_data_div"><form id="formData" method="post" name="form">
        <label class="film_data" for="title">Enter nickname:</label><br>
        <input class="film_data" id="title" type="text" name="title" required maxlength="30"></input><br><br>`
        html += `</select><br><br>
            <input class="film_data" type="button" onclick="addScore()" value="Submit" name="film_save">
            <input class="film_data" type="button" onclick="cancelOverlay()" value="Cancel" name="overLay_cancel">
            </form></div>`;
    input.innerHTML += html;
    over.setAttribute('class', 'overlay');
    over.setAttribute('id', "overlay");
    over.appendChild(input);
    c.parentNode.insertBefore(over, first);
    var inp2 = document.createElement('div');
    inp2.setAttribute('id', "overlayback");
    over.insertBefore(inp2, input);
}

function cancelOverlay() {
    var rem = document.getElementById('overlay');
    return rem.parentNode.removeChild(rem);
}