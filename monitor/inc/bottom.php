
        </section>

      </div> <!-- END .d-flex w-100 -->

    </div> <!-- END .sa-content -->
    
        <footer class="sa-page-footer"> <!-- BEGIN .sa-page-footer -->
            <div class="d-flex align-items-center w-100 h-100">
              <div class="footer-left">
                KOKOFARM           
              </div>
            </div>
        </footer> <!-- END .sa-page-footer -->
      
      </div> <!-- END .sa-content-wrapper -->
      
    </div> <!-- END .sa-page-body -->

  </div> <!-- END .sa-wrapper -->

</body>
</html>

<script src="../../library/vendors/vendors.bundle.js"></script>
<script src="../../library/app/app.bundle.js"></script>

<script>
  $(document).ready(function()
  {
    //농장 목록 트리뷰 (임시 제한)
    if($('div').hasClass('fullSc'))
    {
      $("#treeView").css("display","none");
    }
    
    //농장 목록 트리뷰
    $('.tree > ul').attr('role', 'tree').find('ul').attr('role', 'group');
    $('.tree').find('li:has(ul)').addClass('parent_li').attr('role', 'treeitem').find(' > span').attr('title', 'Collapse this branch').on('click', function(e)
    {
      var children = $(this).parent('li.parent_li').find(' > ul > li');
      if (children.is(':visible')) {
        children.hide('fast');
        $(this).attr('title', 'Expand this branch').find(' > i').removeClass().addClass('fa fa-lg fa-plus-circle');
      } else {
        children.show('fast');
        $(this).attr('title', 'Collapse this branch').find(' > i').removeClass().addClass('fa fa-lg fa-minus-circle');
      }
      e.stopPropagation();
    });

  });
</script>