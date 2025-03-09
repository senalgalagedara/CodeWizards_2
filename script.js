// JavaScript code to handle form submission
document.getElementById('playerForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const playerName = document.getElementById('playerName').value;
    const university = document.getElementById('university').value;
    const runs = document.getElementById('runs').value;
    const totalBallsFaced = document.getElementById('totalBallsFaced').value;
    const innings = document.getElementById('innings').value;
    const totalBalls = document.getElementById('totalBalls').value;
    const wickets = document.getElementById('wickets').value;
    const role = document.getElementById('role').value;

    console.log(`Player Name: ${playerName}`);
    console.log(`University: ${university}`);
    console.log(`Runs: ${runs}`);
    console.log(`Balls Faced: ${totalBallsFaced}`);
    console.log(`Innings: ${innings}`);
    console.log(`Total Balls: ${totalBalls}`);
    console.log(`Wickets: ${wickets}`);
    console.log(`Role: ${role}`);

    alert('Form submitted successfully!');
});
