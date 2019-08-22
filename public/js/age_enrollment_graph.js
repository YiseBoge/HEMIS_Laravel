let ageEnrollmentChart;
$(document).ready(function () {
    updateAgeEnrollmentChart();
    let enrollmentG = document.getElementById('age-enrollment-graph').getContext('2d');
    ageEnrollmentChart = makeChart(enrollmentG, "bar", "Ages", "Enrollments");
    addDataset(ageEnrollmentChart, "Males");
    addDataset(ageEnrollmentChart, "Females", [223, 48, 129]);

    let institutionSelect = $("#age_enrollment_institutions");
    let bandSelect = $("#age_enrollment_bands");
    let collegeSelect = $("#age_enrollment_colleges");
    let departmentSelect = $("#age_enrollment_departments");
    let programSelect = $("#age_enrollment_programs");
    let levelSelect = $("#age_enrollment_education_levels");

    institutionSelect.on("change", function (ev) {
        let nodes = [];
        if (institutionSelect.val() != 0) nodes = nodes.concat([bandSelect.parent()]);
        bandSelect.val(0);
        collegeSelect.val(0);
        departmentSelect.val(0);
        programSelect.val(0);
        levelSelect.val(0);
        updateAgeEnrollmentChart();
        hideAllAgeEnrollment();
        showNodes(nodes)
    });
    bandSelect.on("change", function (ev) {
        let nodes = [];
        nodes = nodes.concat([bandSelect.parent()]);
        if (bandSelect.val() != 0) nodes = nodes.concat([collegeSelect.parent()]);
        collegeSelect.val(0);
        departmentSelect.val(0);
        programSelect.val(0);
        levelSelect.val(0);
        updateAgeEnrollmentChart("cols");
        hideAllAgeEnrollment();
        showNodes(nodes)
    });
    collegeSelect.on("change", function (ev) {
        let nodes = [];
        nodes = nodes.concat([bandSelect.parent(), collegeSelect.parent()]);
        if (collegeSelect.val() != 0) nodes = nodes.concat([departmentSelect.parent(), programSelect.parent(), levelSelect.parent()]);
        departmentSelect.val(0);
        programSelect.val(0);
        levelSelect.val(0);
        updateAgeEnrollmentChart("deps");
        hideAllAgeEnrollment();
        showNodes(nodes);
    });
    departmentSelect.on("change", function (ev) {
        updateAgeEnrollmentChart();
    });
    programSelect.on("change", function (ev) {
        updateAgeEnrollmentChart()
    });
    levelSelect.on("change", function (ev) {
        updateAgeEnrollmentChart()
    })

});

function hideAllAgeEnrollment() {
    $("#age_enrollment_bands").parent().addClass("d-none");
    $("#age_enrollment_colleges").parent().addClass("d-none");
    $("#age_enrollment_departments").parent().addClass("d-none");
    $("#age_enrollment_programs").parent().addClass("d-none");
    $("#age_enrollment_education_levels").parent().addClass("d-none");
}

function updateAgeEnrollmentChart(toDo = 'nothing') {
    let url = "/api/age-enrollment-chart?" + $("#age-enrollments-filter").serialize();

    let loader = $("#age-enrollment-loading");
    loader.removeClass("d-none");
    $('#age-enrollment-graph').css('opacity', 0.3);

    $.ajax({
        url: url,
        type: 'GET',
        success: function (response) {
            let ageRanges = response.age_ranges;
            let maleEnrollments = response.male_enrollments;
            let femaleEnrollments = response.female_enrollments;

            let cols = response.colleges;
            let deps = response.departments;

            if (toDo === "cols") {
                $('#age_enrollment_colleges').find('option').remove().end().append('<option value="0">Any</option>');
                for (let i = 0; i < cols.length; i++) {
                    $("#age_enrollment_colleges").append('<option value=\"' + (i + 1) + '\" selected=\"selected\">' + cols[i] + '</option>')
                }
                $('#age_enrollment_colleges').val('0');
            } else if (toDo === "deps") {
                $('#age_enrollment_departments').find('option').remove().end().append('<option value="0">Any</option>');
                for (let i = 0; i < deps.length; i++) {
                    $("#age_enrollment_departments").append('<option value=\"' + (i + 1) + '\" selected=\"selected\">' + deps[i] + '</option>')
                }
                $('#age_enrollment_departments').val('0');
            }

            updateChartData(ageEnrollmentChart, ageRanges, "Males", maleEnrollments);
            updateChartData(ageEnrollmentChart, ageRanges, "Females", femaleEnrollments);


            $('#age-enrollment-error').addClass('d-none');
            $('#age-enrollment-graph').css('opacity', 1);
            $('#age-enrollment-graph').removeClass('d-none');
            loader.addClass("d-none");
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
            loader.addClass("d-none");
            $('#age-enrollment-graph').addClass('d-none');
            $('#age-enrollment-error').removeClass('d-none');
        }
    });
}