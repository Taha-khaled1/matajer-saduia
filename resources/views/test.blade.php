<div class="container">
    <h6>Checkout</h6>
    <span>x</span>
    <h1>Payment Method</h1>
    <form action="/">
        <label for="country">Country
            <select name="country" id="country">
                <option value="germany">germany</option>
                <option value="england">england</option>
                <option value="india">india</option>

            </select>
        </label>
        <label for="cardno">Card Number
            <input type="text" name="cardno" id="cardno" maxlength="19" onkeypress="cardspace()" />
        </label>
        <div class="float">
            <label for="validtill">Valid till
                <input type="text" name="validtill" id="validtill" maxlength="7" onkeypress="addSlashes()" />
            </label>
            <label for="cvv">Cvv
                <input type="text" name="cvv" id="cvv" maxlength="3" />
            </label>
        </div>
        <label for="checkbox">
            <input type="checkbox" name="checkbox" id="checkbox" />
            <p>Payment Address is the same as the Delivery Address</p>
        </label>
        <button>Pay 89.00 $</button>
    </form>
</div>
