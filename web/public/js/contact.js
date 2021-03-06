$(document).ready(function() {
    $('#contact_form').bootstrapValidator({
        // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            prenom: {
                validators: {
                        stringLength: {
                        min: 2,
                        message:'Entrez au moins 2 caractères'
                    },
                        notEmpty: {
                        message: 'Entrez votre prénom'
                    }
                }
            },
             nom: {
                validators: {
                     stringLength: {
                        min: 2,
                        message:'Entrez au moins 2 caractères'
                    },
                    notEmpty: {
                        message: 'Entrez votre nom'
                    }
                }
            },
            email: {
                validators: {

                    notEmpty: {
                        message: 'Entrez votre e-mail'
                    },
                    emailAddress: {
                        message: 'e-mail non valide'
                    }
                }
            },
            content: {
                validators: {
                    stringLength: {
                        min: 10,
                        message:'Entrez au moins 10 caractères'
                    },
                    notEmpty: {
                        message: 'Entrez au moins 10 caractères'
                    }
                    }
                }
            }
        })
        .on('success.form.bv', function(e) {
            $('#success_message').slideDown({ opacity: "show" }, "slow") // Do something ...
                $('#contact_form').data('bootstrapValidator').resetForm();

            // Prevent form submission
            e.preventDefault();

            // Get the form instance
            var $form = $(e.target);

            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');
            // Use Ajax to submit form data
            $.post(action, $form.serialize(), function(result) {
                console.log(result);
            }, 'json');
        });
});
