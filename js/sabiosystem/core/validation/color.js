Validation.add('validate-color','__(Error. Insert 3 or 6 numbers and letters.)',function(value){
    
    return !(Validation.get('IsEmpty').test(value)) && /[0-9A-F]+$/i.test(value) && (value.length != 3 || value.length != 6);
    }
);