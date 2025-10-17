<div class="rating-container">
  <input type="radio" id="rating-10" name="rating" value="10" />
  <label for="rating-10" class="star-half2" title="5 Stars"></label>
  <input type="radio" id="rating-9" name="rating" value="9" />
  <label for="rating-9" class="star-half1" title="4.5 Stars"></label>

  <input type="radio" id="rating-8" name="rating" value="8" />
  <label for="rating-8" class="star-half2" title="4 Stars"></label>
  <input type="radio" id="rating-7" name="rating" value="7" />
  <label for="rating-7" class="star-half1" title="3.5 Stars"></label>

  <input type="radio" id="rating-6" name="rating" value="6" />
  <label for="rating-6" class="star-half2" title="3 Stars"></label>
  <input type="radio" id="rating-5" name="rating" value="5" />
  <label for="rating-5" class="star-half1" title="2.5 Stars"></label>

  <input type="radio" id="rating-4" name="rating" value="4" />
  <label for="rating-4" class="star-half2" title="2 Stars"></label>
  <input type="radio" id="rating-3" name="rating" value="3" />
  <label for="rating-3" class="star-half1" title="1.5 Stars"></label>

  <input type="radio" id="rating-2" name="rating" value="2" />
  <label for="rating-2" class="star-half2" title="1 Star"></label>
  <input type="radio" id="rating-1" name="rating" value="1" />
  <label for="rating-1" class="star-half1" title="0.5 Stars"></label>

  <input type="radio" id="rating-0" name="rating" value="0" checked />
  <label for="rating-0" class="star-half2" title="No Rating"></label>
</div>

<style>
/* --- CSS for the Star Rating --- */

.rating-container {
    /* Hides the radio inputs while keeping them accessible */
    display: flex;
    flex-direction: row; /* Reverses the order to make higher ratings appear on the right */
    justify-content: flex-end;
    font-size: 2.5em; /* Controls the size of the stars */
    color: #ffd700; /* Gold color for filled stars - NOTE: This color will be overridden by the image, but kept for legacy/fallback */
    unicode-bidi: bidi-override;
    direction: rtl; /* Necessary for the :hover effect to work in reverse */
}

.rating-container > input {
    display: none; /* Hide the actual radio buttons */
}

.rating-container > label {
    display: inline-block;
    padding: 0 0em;
    cursor: pointer;
    line-height: 1;
    transition: none; /* Transition on 'color' is no longer useful when using images */
    gap: 0px;
}

/* Base Star Shape (Uses Image Stars) - Initial state: all stars are gray (unfilled) */
/* Gray Full Star (graystar2.jpg) */
.star-half2::before {
    content: url("Assets/imagenes/stars/graystar2.png");
    /* If the image sizes need adjustment, you might use background-image instead of content */
    /* and set background-size, width, and height on the label or ::before/::after */
}
/* Gray Half Star (graystar1.png) */
.star-half1::before {
    content: url("Assets/imagenes/stars/graystar1.png");
    position: relative;
    right: -0.1em; /* Adjust to better align with the full stars */
}

/* ⬇️ CORRECTED HOVER EFFECT ⬇️ */

/* 1. Target the currently hovered label (using the class on the label) and its ::before pseudo-element */
/* 2. Target all sibling labels to the right (higher rating) */

/* Full Star (.star-half2) Hover/Previous Siblings */
.rating-container > label.star-half2:hover::before,
.rating-container > label:hover ~ label.star-half2::before {
    content: url("Assets/imagenes/stars/goldenstar2.png");
}

/* Half Star (.star-half1) Hover/Previous Siblings */
.rating-container > label.star-half1:hover::before,
.rating-container > label:hover ~ label.star-half1::before {
    content: url("Assets/imagenes/stars/goldenstar1.png");
}

/* ⬆️ CORRECTED HOVER EFFECT ⬆️ */

/* CHECKED STATE: Stars are golden for the selected rating and all lower ratings (due to direction: rtl and ~ selector) */
/* The selected input's sibling label (and all subsequent siblings) should be golden. */
.rating-container > input:checked ~ label.star-half2::before {
    content: url("Assets/imagenes/stars/goldenstar2.png");
}
.rating-container > input:checked ~ label.star-half1::before {
    content: url("Assets/imagenes/stars/goldenstar1.png");
}

/* Ensure 'No Rating' option doesn't break the flow */
#rating-0 ~ label {
    display: none;
}
</style>