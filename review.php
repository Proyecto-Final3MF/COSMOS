<div class="rating-container">
  <input type="radio" id="rating-10" name="rating" value="10" />
  <label for="rating-10" class="star-full" title="5 Stars"></label>
  <input type="radio" id="rating-9" name="rating" value="9" />
  <label for="rating-9" class="star-half" title="4.5 Stars"></label>

  <input type="radio" id="rating-8" name="rating" value="8" />
  <label for="rating-8" class="star-full" title="4 Stars"></label>
  <input type="radio" id="rating-7" name="rating" value="7" />
  <label for="rating-7" class="star-half" title="3.5 Stars"></label>

  <input type="radio" id="rating-6" name="rating" value="6" />
  <label for="rating-6" class="star-full" title="3 Stars"></label>
  <input type="radio" id="rating-5" name="rating" value="5" />
  <label for="rating-5" class="star-half" title="2.5 Stars"></label>

  <input type="radio" id="rating-4" name="rating" value="4" />
  <label for="rating-4" class="star-full" title="2 Stars"></label>
  <input type="radio" id="rating-3" name="rating" value="3" />
  <label for="rating-3" class="star-half" title="1.5 Stars"></label>

  <input type="radio" id="rating-2" name="rating" value="2" />
  <label for="rating-2" class="star-full" title="1 Star"></label>
  <input type="radio" id="rating-1" name="rating" value="1" />
  <label for="rating-1" class="star-half" title="0.5 Stars"></label>

  <input type="radio" id="rating-0" name="rating" value="0" checked />
  <label for="rating-0" class="star-full" title="No Rating"></label>
</div>

<style>
/* --- CSS for the Star Rating --- */

.rating-container {
    /* Hides the radio inputs while keeping them accessible */
    display: flex;
    flex-direction: row; /* Reverses the order to make higher ratings appear on the right */
    justify-content: flex-end;
    font-size: 2.5em; /* Controls the size of the stars */
    color: #ffd700; /* Gold color for filled stars */
    unicode-bidi: bidi-override;
    direction: rtl; /* Necessary for the :hover effect to work in reverse */
}

.rating-container > input {
    display: none; /* Hide the actual radio buttons */
}

.rating-container > label {
    display: inline-block;
    padding: 0 0.1em;
    cursor: pointer;
    line-height: 1;
    transition: color 0.2s ease-in-out;
}

/* Base Star Shape (Uses Unicode Star Characters) */
.star-full::before {
    content: "★"; /* Full Star Character */
}
.star-half::before {
    content: "½"; /* Half Star Character - Letterboxd uses a hollow star for their half-rating but this simple Unicode approach is common */
    position: relative;
    right: -0.1em; /* Adjust to better align with the full stars */
    z-index: 1;
}

/* Initial state: all stars are gray (unfilled) */
.rating-container > label {
    color: #ccc; /* Gray color for empty stars */
}

/* HOVER EFFECT: Changes color as the user hovers over the stars */
.rating-container > label:hover,
.rating-container > label:hover ~ label,
.rating-container > input:checked ~ label {
    color: #ffd700; /* Gold color */
}

/* Letterboxd style: The lower half of the star */
.star-half {
    width: 0.5em; /* Only take up half the width */
    overflow: hidden; /* Hide the other half of the '½' character */
}

/* Ensure 'No Rating' option doesn't break the flow */
#rating-0 ~ label {
    display: none;
}
</style>