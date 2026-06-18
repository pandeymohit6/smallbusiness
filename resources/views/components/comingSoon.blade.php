<style>

    .coming-soon {
        max-width: 900px;
        width: 100%;
        text-align: center;
    }

    .logo {
        font-size: 18px;
        font-weight: 600;
        letter-spacing: 2px;
        margin-bottom: 20px;
        color: #94a3b8;
    }

    h1 {
        font-size: 4rem;
        font-weight: 700;
        margin-bottom: 20px;
        line-height: 1.2;
    }

    p {
        max-width: 650px;
        margin: 0 auto 40px;
        color: #cbd5e1;
        font-size: 1.1rem;
        line-height: 1.8;
    }

    .timer {
        display: flex;
        justify-content: center;
        gap: 20px;
        flex-wrap: wrap;
        margin-bottom: 50px;
    }

    .time-box {
        width: 140px;
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        padding: 25px 15px;
    }

    .time-box h2 {
        font-size: 3rem;
        margin-bottom: 10px;
        color: #38bdf8;
    }

    .time-box span {
        text-transform: uppercase;
        font-size: 14px;
        letter-spacing: 1px;
        color: #cbd5e1;
    }

    .subscribe {
        max-width: 550px;
        margin: auto;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .subscribe input {
        flex: 1;
        min-width: 250px;
        padding: 16px 20px;
        border: none;
        border-radius: 10px;
        font-size: 15px;
    }

    .subscribe button {
        padding: 16px 30px;
        border: none;
        border-radius: 10px;
        background: #0ea5e9;
        color: #fff;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
    }

    .subscribe button:hover {
        background: #0284c7;
    }

    .launch-date {
        margin-bottom: 30px;
        color: #94a3b8;
        font-size: 15px;
    }

    @media(max-width:768px) {
        h1 {
            font-size: 2.5rem;
        }

        .time-box {
            width: 120px;
        }

        .time-box h2 {
            font-size: 2.2rem;
        }
    }
</style>

<div class="coming-soon">

    <div class="logo">SmallBusinessesForSale.com</div>

    <h2>🚀 Something Amazing Is Coming Soon</h2>

    <p>
        We're working hard behind the scenes to bring you an exceptional experience.
        Our new website will launch soon with exciting features, improved performance,
        and a fresh new look.
    </p>

    <div class="launch-date">
        Launch Date: <strong>July 31, 2026</strong>
    </div>

    <div class="timer">
        <div class="time-box">
            <h2 id="days">00</h2>
            <span>Days</span>
        </div>

        <div class="time-box">
            <h2 id="hours">00</h2>
            <span>Hours</span>
        </div>

        <div class="time-box">
            <h2 id="minutes">00</h2>
            <span>Minutes</span>
        </div>

        <div class="time-box">
            <h2 id="seconds">00</h2>
            <span>Seconds</span>
        </div>
    </div>

</div>

<script>
    const launchDate = new Date("July 31, 2026 00:00:00").getTime();

    const timer = setInterval(() => {
        const now = new Date().getTime();
        const distance = launchDate - now;

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById("days").innerHTML = days;
        document.getElementById("hours").innerHTML = hours;
        document.getElementById("minutes").innerHTML = minutes;
        document.getElementById("seconds").innerHTML = seconds;

        if (distance < 0) {
            clearInterval(timer);
            document.querySelector(".timer").innerHTML =
                "<h2>🎉 We Are Live Now!</h2>";
        }
    }, 1000);
</script>
