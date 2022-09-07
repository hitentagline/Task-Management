<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To DO</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/media.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>

</head>

<body>
    <div class="section text-center pt-5">
        <div class="main">
            <h1>My Task board</h1>
            <div id="message"></div>
            <?php echo form_open('taskSubmit', array('id' => 'taskForm', 'class' => 'pt-5 main-form')) ?>
            <input type="text" name="task_name" id="tname" class="form-control" placeholder="Task Name"><br />
            <input type="text" name="task_date" id="tdate" class="form-control" placeholder="Task Date"><br />
            <textarea name="task_desc" id="tdesc" class="form-control" placeholder="Task Description"></textarea>
            <input type="submit" value="Submit">
            <?php echo form_close() ?>
            <div class="tasks_list">
                <?php $this->load->view('tasks_list', $data); ?>
            </div>
        </div>
    </div>
</body>

<script>
    $(function() {
        $("#tdate").datepicker({
            dateFormat: "dd-mm-yy"
        });
    });
    $(function() {
        $("#taskForm").on('submit', function(e) {
            e.preventDefault();

            var taskForm = $(this);

            $.ajax({
                url: taskForm.attr('action'),
                type: 'post',
                data: taskForm.serialize(),
                success: function(response) {

                    if (response.status == 'success') {
                        // alert(response.message);
                        $("#message").html('');
                        $("#taskForm")[0].reset();

                        var date = new Date(response.data.task_date),
                            yr = date.getFullYear(),
                            month = date.getMonth() + +1,
                            day = date.getDate(),
                            newDate = day + '/' + month + '/' + yr;
                        $("tr").prepend('<td class="task_' + response.id + '"><div class="task"><button class="close-icon" onclick="delete_task(' + response.id + ')"><svg fill="currentcolor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30" width="30px" height="30px"><path d="M 7 4 C 6.744125 4 6.4879687 4.0974687 6.2929688 4.2929688 L 4.2929688 6.2929688 C 3.9019687 6.6839688 3.9019687 7.3170313 4.2929688 7.7070312 L 11.585938 15 L 4.2929688 22.292969 C 3.9019687 22.683969 3.9019687 23.317031 4.2929688 23.707031 L 6.2929688 25.707031 C 6.6839688 26.098031 7.3170313 26.098031 7.7070312 25.707031 L 15 18.414062 L 22.292969 25.707031 C 22.682969 26.098031 23.317031 26.098031 23.707031 25.707031 L 25.707031 23.707031 C 26.098031 23.316031 26.098031 22.682969 25.707031 22.292969 L 18.414062 15 L 25.707031 7.7070312 C 26.098031 7.3170312 26.098031 6.6829688 25.707031 6.2929688 L 23.707031 4.2929688 C 23.316031 3.9019687 22.682969 3.9019687 22.292969 4.2929688 L 15 11.585938 L 7.7070312 4.2929688 C 7.5115312 4.0974687 7.255875 4 7 4 z" /></svg></button><h6>' + response.data.task_name + '</h6><p class="date">Date:- ' + newDate + '<span></span></p><p>' + response.data.task_desc + '</p></div></td>');
                    } else {
                        $("#message").html(response.message);
                    }


                }
            });
        });
    });

    function delete_task(id) {

        $.ajax({
            url: '<?php echo base_url('deleteTask'); ?>',
            type: 'post',
            data: {
                id: id
            },
            success: function(response) {
                if (response.status == 'success') {
                    $('.task_' + id).remove();
                }
            }
        });

    }
</script>

</html>