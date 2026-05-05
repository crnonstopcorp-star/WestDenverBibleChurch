document.addEventListener("DOMContentLoaded", function () {

  const items = document.querySelectorAll(".item");

  items.forEach(item => {
    const top = item.querySelector(".top");

    top.addEventListener("click", () => {

      // if already open → CLOSE it
      if (item.classList.contains("active")) {
        item.classList.remove("active");
        item.querySelector(".icon").textContent = "+";
        return;
      }

      // close all items
      items.forEach(i => {
        i.classList.remove("active");
        i.querySelector(".icon").textContent = "+";
      });

      // open clicked item
      item.classList.add("active");
      item.querySelector(".icon").textContent = "−";

    });
  });

});



$(document).ready(function () {

    /* ONLY ALPHABETS */
    $.validator.addMethod(
        "lettersOnly",
        function(value, element) {
            return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
        },
        "Please enter only alphabets"
    );

    /* ONLY NUMBERS */
    $.validator.addMethod(
        "numbersOnly",
        function(value, element) {
            return this.optional(element) || /^[0-9]+$/.test(value);
        },
        "Please enter only numbers"
    );



    $(".contact-form").validate({

        rules: {

            first_name: {
                required: true,
                minlength: 2,
                maxlength: 30,
                lettersOnly: true
            },

            last_name: {
                required: true,
                minlength: 2,
                maxlength: 30,
                lettersOnly: true
            },

            email: {
                required: true,
                email: true
            },

            phone: {
                required: true,
                numbersOnly: true,
                minlength: 10,
                maxlength: 10
            },

            help: {
                required: true
            },

            message: {
                required: true,
                minlength: 10,
                maxlength: 200
            }

        },

        messages: {

            first_name: {
                required: "Please enter first name",
                minlength: "Minimum 2 characters required",
                lettersOnly: "Only alphabets allowed"
            },

            last_name: {
                required: "Please enter last name",
                minlength: "Minimum 2 characters required",
                lettersOnly: "Only alphabets allowed"
            },

            email: {
                required: "Please enter email address",
                email: "Please enter valid email address"
            },

            phone: {
                required: "Please enter phone number",
                numbersOnly: "Only numbers allowed",
                minlength: "Phone number must be 10 digits",
                maxlength: "Phone number must be 10 digits"
            },

            help: {
                required: "Please select inquiry type"
            },

            message: {
                required: "Please enter message",
                minlength: "Message should be minimum 10 characters",
                maxlength: "Maximum 200 characters allowed"
            }

        },

        errorElement: "span",

        errorPlacement: function(error, element) {

            error.addClass("error-message");

            if (element.attr("type") == "radio") {
                error.appendTo(".radio-wrapper");
            } else {
                error.insertAfter(element);
            }
        },

        highlight: function(element) {
            $(element).addClass("input-error");
        },

        unhighlight: function(element) {
            $(element).removeClass("input-error");
        },

        submitHandler: function(form) {

            Swal.fire({
                title: "Confirm Submission",
                text: "Are you sure you want to submit this form?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Yes, Submit",
                cancelButtonText: "Cancel",
                confirmButtonColor: "#355c50",
                cancelButtonColor: "#d33"
            }).then((result) => {

                if (result.isConfirmed) {

                    Swal.fire({
                        title: "Submitting...",
                        text: "Please wait",
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    form.submit();
                }

            });

        }
    });

});
