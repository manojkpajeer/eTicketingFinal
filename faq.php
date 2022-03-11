<?php 
    session_start();

    require_once './config/connection.php';
    require_once './pages/link.php';
    require_once './pages/header.php';
?>


<section class="w3l-faq-1">
    <div class="w3l-faq-page">
        <div class="wrapper">
          <div class="faq-column-grid">
            <div class="faq-column">
              <h3>FAQ Pages</h3>
              <details open="">
                <summary>
                  How can i get help?
                  <span class="fa control-icon-expand fa-chevron-down"></span>
                  <span class="fa control-icon-close fa-times"></span>
                </summary>
                <p>Curabitur dapibus non massa sed maximus. Nam venenatis justo vitae sodales mattis. Vestibulum at
                  ullamcorper
                  neque,
                  vel lobortis tellus. consectetur vitae fringilla eu, ornare eu augue. Aliquam in tincidunt dui, nec mattis
                  velit.
                  Mauris at mauris erat. </p>
              </details>
              <details>
                <summary>
                  How do I sign up?
                  <span class="fa control-icon-expand fa-chevron-down"></span>
                  <span class="fa control-icon-close fa-times"></span>
                </summary>
                <p>Curabitur dapibus non massa sed maximus. Nam venenatis justo vitae sodales mattis. Vestibulum at
                  ullamcorper
                  neque,
                  vel lobortis tellus. consectetur vitae fringilla eu, ornare eu augue. Aliquam in tincidunt dui, nec mattis
                  velit.
                  Mauris at mauris erat. </p>
              </details>
              <details>
                <summary>
                  Can I remove a post?
                  <span class="fa control-icon-expand fa-chevron-down"></span>
                  <span class="fa control-icon-close fa-times"></span>
                </summary>
                <p>Curabitur dapibus non massa sed maximus. Nam venenatis justo vitae sodales mattis. Vestibulum at
                  ullamcorper
                  neque,
                  vel lobortis tellus. consectetur vitae fringilla eu, ornare eu augue. Aliquam in tincidunt dui, nec mattis
                  velit.
                  Mauris at mauris erat. </p>
              </details>
              <details>
                <summary>
                  How do reviews work?
                  <span class="fa control-icon-expand fa-chevron-down"></span>
                  <span class="fa control-icon-close fa-times"></span>
                </summary>
                <p>Curabitur dapibus non massa sed maximus. Nam venenatis justo vitae sodales mattis. Vestibulum at
                  ullamcorper
                  neque,
                  vel lobortis tellus. consectetur vitae fringilla eu, ornare eu augue. Aliquam in tincidunt dui, nec mattis
                  velit.
                  Mauris at mauris erat. </p>
              </details>
            </div>
            
          </div>
          <div class="testi-top">
						<h3 class="title-main2">Didn't find the answer?</h3>
						<div class="form-commets">
							<form action="#" method="post">
								<div class="media">
									<input type="text" name="Name" required="Name" placeholder="Your Name">
									<input type="email" name="Email" required="Email" placeholder="Your Email">
								</div>
								
										<input type="text" name="Name" required="Name" placeholder="Subject">
								
								<textarea name="Message" required="" placeholder="Write your comments here"></textarea>
								<button class="btn button-eff" type="submit">Post comment</button>
							</form>
						</div>
					</div>
        </div>
      </div>
     </section>

<?php
    require_once './pages/newsletter.php';
    require_once './pages/footer.php';
?>