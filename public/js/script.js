var academicStaff = document.getElementById('academic-staff');
var technicalStaff = document.getElementById('technical-staff');
var adminStaff = document.getElementById('administrative-staff');
var ictStaff = document.getElementById('ict-staff');
var supportiveStaff = document.getElementById('supportive-staff');

var ictStaffCategory = document.getElementById('ict-category');
var ictStaffType = document.getElementById('ict-type');

var ictCategory1 = ['Junior Network Administrator', 'Network Administrator', 'Senior Network Administrator', 'Network Engineer', 'Junior system administrator',
    'System administrator', 'Senior system administrator', 'Systems Engineer'];
var ictCategory2 = ['Junior Application/Software Developer', 'Application/Software Developer', 'Senior Application/ Software Developer', 'Junior Application Administrator',
    'Application Administrator', 'Database Administrator'];
var ictCategory3 = ['Video Conference Technician', 'Junior E-learning Administrator', 'Web Admin', 'Content Developer'];
var ictCategory4 = ['Junior Support Technician', 'Support Technician', 'Senior Support Technician', 'Maintenance Technician', 'Support Maintenance Technician-I',
    'Support Maintenance Technician-II', 'Support Maintenance Technician-III', 'Senior Maintenance Technician', 'IT Attendant'];
var ictCategory5 = ['Training project manager', 'Training Admin Assistant'];


for (var i = 0; i < ictCategory1.length; i++) {
    var option = document.createElement('option');
    option.textContent = ictCategory1[i];
    option.value = ictCategory1[i];
    ictStaffType.appendChild(option)
}

ictStaffCategory.addEventListener('change', function (e) {
    ictStaffType.innerHTML = '';
    var selected = ictStaffCategory.options[ictStaffCategory.selectedIndex].value;
    switch (selected) {
        case 'ictCategory1':
            for (var i = 0; i < ictCategory1.length; i++) {
                var option = document.createElement('option');
                option.textContent = ictCategory1[i];
                option.value = ictCategory1[i];
                ictStaffType.appendChild(option)
            }
            break;
        case 'ictCategory2':
            for (var i = 0; i < ictCategory2.length; i++) {
                var option = document.createElement('option');
                option.textContent = ictCategory2[i];
                option.value = ictCategory2[i];
                ictStaffType.appendChild(option)
            }
            break;
        case 'ictCategory3':
            for (var i = 0; i < ictCategory3.length; i++) {
                var option = document.createElement('option');
                option.textContent = ictCategory3[i];
                option.value = ictCategory3[i];
                ictStaffType.appendChild(option)
            }
            break;
        case 'ictCategory4':
            for (var i = 0; i < ictCategory4.length; i++) {
                var option = document.createElement('option');
                option.textContent = ictCategory4[i];
                option.value = ictCategory4[i];
                ictStaffType.appendChild(option)
            }
            break;
        case 'ictCategory5':
            for (var i = 0; i < ictCategory5.length; i++) {
                var option = document.createElement('option');
                option.textContent = ictCategory5[i];
                option.value = ictCategory5[i];
                ictStaffType.appendChild(option)
            }
            break
    }
});
