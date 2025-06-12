# Font Size 
_______________________

<p class="fs-1">.fs-1 text</p>
<p class="fs-2">.fs-2 text</p>
<p class="fs-3">.fs-3 text</p>
<p class="fs-4">.fs-4 text</p>
<p class="fs-5">.fs-5 text</p>
<p class="fs-6">.fs-6 text</p>

```html
<p class="fs-1">.fs-1 text</p>
<p class="fs-2">.fs-2 text</p>
<p class="fs-3">.fs-3 text</p>
<p class="fs-4">.fs-4 text</p>
<p class="fs-5">.fs-5 text</p>
<p class="fs-6">.fs-6 text</p>
```

# Font weight and italics
_______________________

<p class="fw-bold">Bold text.</p>
<p class="fw-bolder">Bolder weight text (relative to the parent element).</p>
<p class="fw-normal">Normal weight text.</p>
<p class="fw-light">Light weight text.</p>
<p class="fw-lighter">Lighter weight text (relative to the parent element).</p>
<p class="fst-italic">Italic text.</p>
<p class="fst-normal">Text with normal font style</p>

```html
<p class="fw-bold">Bold text.</p>
<p class="fw-bolder">Bolder weight text (relative to the parent element).</p>
<p class="fw-normal">Normal weight text.</p>
<p class="fw-light">Light weight text.</p>
<p class="fw-lighter">Lighter weight text (relative to the parent element).</p>
<p class="fst-italic">Italic text.</p>
<p class="fst-normal">Text with normal font style</p>
```

# Spacing
_________________________

Bootstrap includes a wide range of shorthand responsive margin, padding, and gap utility classes to modify an element’s appearance.

<p>Assign responsive-friendly <code>margin</code> or <code>padding</code> values to an element or a subset of its sides with shorthand classes. Includes support for individual properties, all properties, and vertical and horizontal properties. Classes are built from a default Sass map ranging from <code>.25rem</code> to <code>3rem</code>.</p>

<p>Spacing utilities that apply to all breakpoints, from <code>xs</code> to <code>xxl</code>, have no breakpoint abbreviation in them. This is because those classes are applied from <code>min-width: 0</code> and up, and thus are not bound by a media query. The remaining breakpoints, however, do include a breakpoint abbreviation.</p>

<p>The classes are named using the format <code>{property}{sides}-{size}</code> for <code>xs</code> and <code>{property}{sides}-{breakpoint}-{size}</code> for <code>sm</code>, <code>md</code>, <code>lg</code>, <code>xl</code>, and <code>xxl</code>.</p>

<p>Where <em>property</em> is one of:</p>

<ul>
<li><code>m</code> - for classes that set <code>margin</code></li>
<li><code>p</code> - for classes that set <code>padding</code></li>
</ul>

<p>Where <em>sides</em> is one of:</p>

<ul>
<li><code>t</code> - for classes that set <code>margin-top</code> or <code>padding-top</code></li>
<li><code>b</code> - for classes that set <code>margin-bottom</code> or <code>padding-bottom</code></li>
<li><code>s</code> - (start) for classes that set <code>margin-left</code> or <code>padding-left</code> in LTR, <code>margin-right</code> or <code>padding-right</code> in RTL</li>
<li><code>e</code> - (end) for classes that set <code>margin-right</code> or <code>padding-right</code> in LTR, <code>margin-left</code> or <code>padding-left</code> in RTL</li>
<li><code>x</code> - for classes that set both <code>*-left</code> and <code>*-right</code></li>
<li><code>y</code> - for classes that set both <code>*-top</code> and <code>*-bottom</code></li>
<li>blank - for classes that set a <code>margin</code> or <code>padding</code> on all 4 sides of the element</li>
</ul>

# Display property
_____________________________

<p>Display utility classes that apply to all breakpoints, from <code>xs</code> to <code>xxl</code>, have no breakpoint abbreviation in them. This is because those classes are applied from <code>min-width: 0;</code> and up, and thus are not bound by a media query. The remaining breakpoints, however, do include a breakpoint abbreviation.</p>

<p>As such, the classes are named using the format:</p>

<ul>
<li><code>.d-{value}</code> for <code>xs</code></li>
<li><code>.d-{breakpoint}-{value}</code> for <code>sm</code>, <code>md</code>, <code>lg</code>, <code>xl</code>, and <code>xxl</code>.</li>
</ul>

<p>Where <em>value</em> is one of:</p>

<ul>
<li><code>none</code></li>
<li><code>inline</code></li>
<li><code>inline-block</code></li>
<li><code>block</code></li>
<li><code>grid</code></li>
<li><code>table</code></li>
<li><code>table-cell</code></li>
<li><code>table-row</code></li>
<li><code>flex</code></li>
<li><code>inline-flex</code></li>
</ul>

<p>The display values can be altered by changing the <code>$displays</code> variable and recompiling the SCSS.</p>

<p>The media queries affect screen widths with the given breakpoint <em>or larger</em>. For example, <code>.d-lg-none</code> sets <code>display: none;</code> on <code>lg</code>, <code>xl</code>, and <code>xxl</code> screens.</p>

<table class="table table-bordered">
  <thead>
    <tr>
      <th>Screen size</th>
      <th>Class</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Hidden on all</td>
      <td><code>.d-none</code></td>
    </tr>
    <tr>
      <td>Hidden only on xs</td>
      <td><code>.d-none .d-sm-block</code></td>
    </tr>
    <tr>
      <td>Hidden only on sm</td>
      <td><code>.d-sm-none .d-md-block</code></td>
    </tr>
    <tr>
      <td>Hidden only on md</td>
      <td><code>.d-md-none .d-lg-block</code></td>
    </tr>
    <tr>
      <td>Hidden only on lg</td>
      <td><code>.d-lg-none .d-xl-block</code></td>
    </tr>
    <tr>
      <td>Hidden only on xl</td>
      <td><code>.d-xl-none .d-xxl-block</code></td>
    </tr>
    <tr>
      <td>Hidden only on xxl</td>
      <td><code>.d-xxl-none</code></td>
    </tr>
    <tr>
      <td>Visible on all</td>
      <td><code>.d-block</code></td>
    </tr>
    <tr>
      <td>Visible only on xs</td>
      <td><code>.d-block .d-sm-none</code></td>
    </tr>
    <tr>
      <td>Visible only on sm</td>
      <td><code>.d-none .d-sm-block .d-md-none</code></td>
    </tr>
    <tr>
      <td>Visible only on md</td>
      <td><code>.d-none .d-md-block .d-lg-none</code></td>
    </tr>
    <tr>
      <td>Visible only on lg</td>
      <td><code>.d-none .d-lg-block .d-xl-none</code></td>
    </tr>
    <tr>
      <td>Visible only on xl</td>
      <td><code>.d-none .d-xl-block .d-xxl-none</code></td>
    </tr>
    <tr>
      <td>Visible only on xxl</td>
      <td><code>.d-none .d-xxl-block</code></td>
    </tr>
  </tbody>
</table>

# Full Documents 

https://getbootstrap.com/docs