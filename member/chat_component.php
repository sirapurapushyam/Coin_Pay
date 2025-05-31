<?php
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: http://localhost/coin/sign_up.php");
    exit;
}

include "includes/db_connection.php";
$stmt = $conn->prepare("SELECT DISTINCT `$coin_id` FROM friends WHERE `$coin_id` IS NOT NULL AND `$coin_id` <> ''");
$stmt->execute();
$result = $stmt->get_result();

$friends = array();
while ($row = $result->fetch_assoc()) {
    $friend = $row[$coin_id];
    if (!empty($friend)) {
        $friends[] = $friend;
    }
}
?>
<style>
    <style>.chat-icon {
        position: fixed;
        top: 90%;
        right: 20px;
        z-index: 9999;
    }

    .wrapper {
        width: 370px;
        background: #fff;
        border-radius: 5px;
        border: 1px solid lightgrey;
        border-top: 0px;
    }

    .wrapper .title {
        background:var(--primary);
        color: #fff;
        font-size: 20px;
        font-weight: 500;
        line-height: 60px;
        text-align: center;
        border-bottom: 1px solid var(--primary);
        border-radius: 5px 5px 0 0;
        user-select: none;
    }

    .wrapper .form {
        padding: 20px 15px;
        min-height: 400px;
        max-height: 400px;
        overflow-y: auto;
    }

    .wrapper .form .inbox {
        width: 100%;
        display: flex;
        align-items: baseline;
    }

    .wrapper .form .user-inbox {
        justify-content: flex-end;
        margin: 13px 0;
    }

    .wrapper .form .inbox .icon {
        height: 40px;
        width: 40px;
        color: #fff;
        text-align: center;
        line-height: 40px;
        border-radius: 50%;
        font-size: 18px;
        background:var(--primary);
    }

    .wrapper .form .inbox .msg-header {
        max-width: 53%;
        margin-left: 10px;
    }

    .form .inbox .msg-header p {
        color: #fff;
        background:var(--primary);
        border-radius: 10px;
        padding: 8px 10px;
        font-size: 14px;
        word-break: break-all;
    }

    .form .user-inbox .msg-header p {
        color: #333;
        background: #efefef;
    }

    .wrapper .typing-field {
        display: flex;
        height: 60px;
        width: 100%;
        align-items: center;
        justify-content: space-evenly;
        background: #efefef;
        border-top: 1px solid #d9d9d9;
        border-radius: 0 0 5px 5px;
    }

    .wrapper .typing-field .input-data {
        height: 40px;
        width: 335px;
        position: relative;
    }

    .wrapper .typing-field .input-data input {
        height: 100%;
        width: 100%;
        outline: none;
        border: 1px solid transparent;
        padding: 0 80px 0 15px;
        border-radius: 3px;
        font-size: 15px;
        background: #fff;
        transition: all 0.3s ease;
    }

    .typing-field .input-data input:focus {
        border-color: var(--primary);
    }

    .input-data input::placeholder {
        color: #999999;
        transition: all 0.3s ease;
    }

    .input-data input:focus::placeholder {
        color: #bfbfbf;
    }

    .wrapper .typing-field .input-data button {
        position: absolute;
        right: 5px;
        top: 50%;
        height: 30px;
        width: 65px;
        color: #fff;
        font-size: 16px;
        cursor: pointer;
        outline: none;
        opacity: 0;
        pointer-events: none;
        border-radius: 3px;
        background:var(--primary);
        border: 1px solid var(--primary);
        transform: translateY(-50%);
        transition: all 0.3s ease;
    }

    .wrapper .typing-field .input-data input:valid~button {
        opacity: 1;
        pointer-events: auto;
    }

    .typing-field .input-data button:hover {
        background: var(--primary);
    }

    .coin-select {
        text-align: center;
        margin-bottom: 20px;
    }

    .coin-select label {
        display: block;
        margin-bottom: 5px;
        text-align: center;
    }

    .coin-select select {
        width: 80%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }

    .coin-select select:hover,
    .coin-select select:focus {
        border-color: var(--primary);
        outline: none;
    }

    .user-inbox {
        display: flex;
        justify-content: flex-end;
    }

    .bot-inbox {
        display: flex;
        justify-content: flex-start;
    }

    .msg-header {
        background-color: #f1f0f0;
        border-radius: 5px;
        padding: 10px;
        margin: 5px;
    }

    .time-right {
        color: #aaa;
        font-size: 12px;
    }

    .currency {
        font-size: 20px;
        color: green;
        font-weight: normal;
    }
</style>
<button id="chatIcon" class="btn btn-primary chat-icon chat-button" type="button" data-bs-toggle="offcanvas"
    data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
    <i class="fas fa-comment fa-lg"></i>

</button>

<<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="wrapper">
            <div class="coin-select">
                <label for="coinId" class="justify-content-center">Select Coin ID:</label>
                <select id="coinId" name="coinId">
                    <option value="">Select your friend</option>
                    <?php foreach ($friends as $friend): ?>
                        <option value="<?php echo $friend; ?>"><?php echo $friend; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="title">COIN PAY CHAT</div>
            <div class="form" id="chatArea">
                <div class="bot-inbox inbox">
                    <div class="msg-header">
                        <p>Select The Coin ID To Chat!!</p>
                    </div>
                </div>
            </div>
            <div class="typing-field">
                <div class="input-data">
                    <input id="data" type="text" placeholder="Type something here.." required>
                    <button id="send-btn">Send</button>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        let chatRefreshInterval;

        function updateChatArea() {
            var coinId = $('#coinId').val();
            $.ajax({
                url: 'fetch_friends.php',
                type: 'POST',
                data: { coinId: coinId },
                success: function (response) {
                    $('#chatArea').html(response);
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        }

        function startChatRefresh() {
            stopChatRefresh();
            chatRefreshInterval = setInterval(function () {
                var coinId = $('#coinId').val();
                if (coinId !== '') {
                    updateChatArea();
                }
            }, 3000);
        }

        function stopChatRefresh() {
            clearInterval(chatRefreshInterval);
        }

        $(document).ready(function () {
            updateChatArea();

            $('#coinId').change(function () {
                updateChatArea();
                startChatRefresh();
            });

            $('#send-btn').click(function () {
                var coinId = $('#coinId').val();
                var message = $('#data').val();
                if (message.trim() !== '') {
                    $.ajax({
                        url: 'send_message.php',
                        type: 'POST',
                        data: { coinId: coinId, message: message },
                        success: function (response) {
                            $('#data').val('');
                            updateChatArea();
                        },
                        error: function (xhr, status, error) {
                            console.error(error);
                        }
                    });
                }
            });

            $('#offcanvasRight').on('show.bs.offcanvas', function () {
                $('#chatIcon').hide();
            });

            $('#offcanvasRight').on('hidden.bs.offcanvas', function () {
                $('#chatIcon').show();
                stopChatRefresh();
            });
        });

    </script>
    <script>
        $(document).ready(function () {
            $('#offcanvasRight').on('show.bs.offcanvas', function () {
                $('#chatIcon').hide();
            });

            $('#offcanvasRight').on('hidden.bs.offcanvas', function () {
                $('#chatIcon').show();
            });
        });
    </script>