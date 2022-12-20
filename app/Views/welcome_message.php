<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee List</title>

    <script type="text/javascript" charset="utf8" src="/scripts/jquery-3.6.2.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.4/css/fixedHeader.dataTables.css"/>

    <script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/fixedheader/3.1.4/js/dataTables.fixedHeader.js"></script>
    <link rel="stylesheet" type="text/css" href="/style/main.css?<?=time()?>">
</head>
<body>

<header>
    <div class="header-container">
        <h2>Data Table Assignment</h2>
        <div id="search-box">
        <span><strong>Filter by Department:</strong> 
        <!-- <input type="text" id="department_seach_box" placeholder="Enter department name"/></span> -->
        <select id="department_seach_box">
        <option value="">All</option>
            <option value="Accounting">Accounting</option>
            <option value="Engineering">Engineering</option>
            <option value="Finance">Finance</option>
            <option value="Human Resources">Human Resources</option>
            <option value="IT">IT</option>
            <option value="Marketing">Marketing</option>
            <option value="Sales">Sales</option>
        </select> 
        Total Salary: $<input type="text"  id="total-salary" size="10" readonly/>
        Average Age: <input type="text"  id="average-age" size="5" readonly/>
        Selected Employee Count: <input type="text"  id="selected-employee-count" size="5" readonly/>
    </div>
    </div>
</header>

<section>
    <table id="data_table" class="display">
    <thead>
        <tr>
            <th><input type="checkbox" id="select-all" /></th>
            <?php
                foreach($headers as $header) {
                    echo '<th>' . $header . '</th>';
                }
            ?>
        </tr>
    </thead>
    <tbody>
            <?php
                 foreach($data as $row) {
                    echo '<tr><td><input type="checkbox" value="' . $row[0] . '" class="emp_checkbox"/></td>';
                    $index = 0;
                    foreach($row as $value) {
                        switch($index) {
                            case 7:
                                echo '<td id="age-' . $row[0] . '">' . $value . '</td>';
                                break;
                            case 9:
                                echo '<td id="salary-' . $row[0] . '">' . $value . '</td>';
                                break;
                            default:
                                echo '<td>' . $value . '</td>';
                        }
                        $index++;
                    }
                    echo '</tr>';
                }
            ?>
    </tbody>
    </table>
</section>

<script>
    $(document).ready(function () {
        let dataTable = $('#data_table').DataTable({
            // dom: 'lrtip', // Hide the global search input 
            columnDefs: [ // Hide the sortating buttom from the first column
                { orderable: false, targets: 0 }
            ],
            order: [], // Prevent the default sorting on the first column
            pageLength: 50,
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, 'All']
            ],
            fixedHeader : {
                header : true,
                footer : false,
                headerOffset: 123
        }
    });

    $('#department_seach_box').on('change', function() {
        // Reset checkboxes
        $('#select-all').prop('checked', false);
        $('.emp_checkbox:checkbox').prop('checked', false);
        updateSalaryAndAge('', '', '');

        dataTable
            .columns(4) // "Department" is the 5th column.
            .search(this.value)
            .draw();
    });

    $(".emp_checkbox").on('click', function() {
        displaySalaryAndAge();
    });

    $('#select-all').on('click', function() {
        $('.emp_checkbox').prop('checked', this.checked);
        displaySalaryAndAge();
    });

    function displaySalaryAndAge() {
        let totalSalary = 0;
        let totalAge = 0;
        let selectedElements = $(".emp_checkbox:checked");

        // No employee is selected. Initialize the display.
        if (selectedElements.length == 0) {
            updateSalaryAndAge('', '', '');
            return;
        }

        selectedElements.each(function(){
            totalSalary += Number($("#salary-" + this.value).text());
            totalAge += Number($("#age-" + this.value).text());
        });

        // Display the average age with the first decimal place
        let averageAge = Number(totalAge / selectedElements.length).toFixed(1);

        updateSalaryAndAge(totalSalary, averageAge, selectedElements.length);
    }

    function updateSalaryAndAge(totalSalary, averageAge, totalSelected) {
        $("#total-salary").val(totalSalary.toLocaleString());
        $("#average-age").val(averageAge);
        $("#selected-employee-count").val(totalSelected);
    }
});
</script>

</body>
</html>