<?xml version="1.0" encoding="UTF-8"?>
<?altova_samplexml ../../twilight/portfolio.xml?>
<xsl:stylesheet version="1.0" xmlns:twix="http://3amproductions.net/xml/ns/twix/" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:xhtml="http://www.w3.org/1999/xhtml" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" exclude-result-prefixes="xsi twix xhtml dc">
	<!--<xsl:output method="xml" version="1.0" encoding="UTF-8" media-type="application/xhtml+xml" indent="yes" omit-xml-declaration="no" doctype-public="-//W3C//DTD XHTML 1.1//EN" doctype-system="http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"/>-->
	<xsl:output method="xml" version="1.0" encoding="UTF-8" media-type="application/xhtml+xml" indent="yes" omit-xml-declaration="yes"/>
	<xsl:param name="project_id"/>
	<xsl:param name="create_root"/>
	<xsl:template match="/">
		<xsl:choose>
			<xsl:when test="$create_root = 'true'">
				<html>
					<head>
						<title>3AM Productions ||| we make websites</title>
					</head>
					<body>
						<div>
							<xsl:call-template name="root"/>
						</div>
					</body>
				</html>
			</xsl:when>
			<xsl:otherwise>
				<xsl:call-template name="root"/>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>
	<xsl:template name="root">
		<xsl:choose>
			<xsl:when test="$project_id != ''">
				<xsl:apply-templates select="twix:portfolio/twix:project[@id = $project]" mode="project"/>
			</xsl:when>
			<xsl:otherwise>
				<div id="controls">
					<a class="undo disabled" href="undo" title="Undo Delete">
						<span>Undo</span>
					</a>
					<a class="save disabled" href="save" title="Save Changes">
						<span>Save</span>
					</a>
					<a class="commit disabled" href="commit" title="Commit Changes">
						<span>Commit</span>
					</a>
					<span id="status"></span>
				</div>
				<div id="errors" class="jqmWindow"><h2>Errors:</h2><!-- <a href="#" class="jqmClose">Close</a> --><p></p></div>
				<div class="projects">
					<xsl:apply-templates select="twix:portfolio/twix:project" mode="project"/>
					<a class="add" href="project" title="Add Project">
						<span>Add</span>
					</a>
				</div>
				<div id="templates">
					<div id="project">
						<xsl:call-template name="project"/>
					</div>
					<div id="contact">
						<xsl:call-template name="contact"/>
					</div>
					<div id="email">
						<xsl:call-template name="email"/>
					</div>
					<div id="phone">
						<xsl:call-template name="phone"/>
					</div>
					<div id="address">
						<xsl:call-template name="address"/>
					</div>
					<div id="note">
						<xsl:call-template name="note"/>
					</div>
					<div id="screenshot">
						<xsl:call-template name="screenshot"/>
					</div>
				</div>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>
	<xsl:template name="project" match="twix:project" mode="project">
		<!--<div id="{@id}" class="project">-->
		<div class="project">
			<h2 class="name">
				<xsl:choose>
					<xsl:when test="twix:showcase/twix:title">
						<xsl:value-of select="twix:showcase/twix:title"/>
					</xsl:when>
					<xsl:otherwise>
						<xsl:choose>
							<xsl:when test="@id">
								<xsl:value-of select="@id"/>
							</xsl:when>
							<xsl:otherwise>
								<xsl:text>New Project</xsl:text>
							</xsl:otherwise>
						</xsl:choose>
					</xsl:otherwise>
				</xsl:choose>
			</h2>
			<a class="delete" href="project" title="Delete this Project">
				<span>Delete</span>
			</a>
			<form action="portfolio.php">
				<fieldset>
					<!--<input type="hidden" name="project" value="{@id}"/>-->
					<label class="id">
						<span>ID</span>
						<input name="id" value="{@id}" type="text"/>
					</label>
					<label class="status">
						<span>Status</span>
						<select name="status">
							<optgroup label="Status">
								<option value="completed">
									<xsl:if test="@status = 'completed'">
										<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
									</xsl:if>
									<xsl:text>Completed</xsl:text>
								</option>
								<option value="draft">
									<xsl:if test="@status = 'draft'">
										<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
									</xsl:if>
									<xsl:text>Draft</xsl:text>
								</option>
								<option value="hold">
									<xsl:if test="@status = 'hold'">
										<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
									</xsl:if>
									<xsl:text>On Hold</xsl:text>
								</option>
								<option value="managed">
									<xsl:if test="@status = 'managed'">
										<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
									</xsl:if>
									<xsl:text>Managed</xsl:text>
								</option>
								<option value="progress">
									<xsl:if test="@status = 'progress'">
										<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
									</xsl:if>
									<xsl:text>In Progress</xsl:text>
								</option>
								<option value="terminated">
									<xsl:if test="@status = 'terminated'">
										<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
									</xsl:if>
									<xsl:text>Terminated</xsl:text>
								</option>
							</optgroup>
						</select>
					</label>
				</fieldset>
				<fieldset class="contact-info">
					<legend>Contact Information</legend>
					<label class="organization">
						<span>Organization</span>
						<input name="organization" value="{twix:organization}" type="text"/>
					</label>
					<label class="abbr">
						<span>Abbreviation</span>
						<input name="abbr" value="{twix:organization/@abbr}" type="text"/>
					</label>
					<label class="url">
						<span>Livesite</span>
						<input name="livesite" value="{twix:livesite}" type="text" class="url"/>
						<a class="preview" href="livesite" title="Preview this URL">
							<span>Preview</span>
						</a>
					</label>
					<fieldset class="contacts">
						<legend>Contacts</legend>
						<xsl:apply-templates select="twix:contacts/twix:contact"/>
						<a class="add" href="contact" title="Add Contact">
							<span>Add</span>
						</a>
					</fieldset>
				</fieldset>
				<fieldset class="management">
					<legend>Management</legend>
					<label class="started">
						<span>Date Started</span>
						<input name="started" value="{twix:started}" type="text" class="date"/>
					</label>
					<label class="modified">
						<span>Date Modified</span>
						<input name="modified" value="{twix:modified}" type="text" class="date"/>
					</label>
					<label class="launched">
						<span>Date Launched</span>
						<input name="launched" value="{twix:launched}" type="text" class="date"/>
					</label>
					<label class="class">
						<span>Class/Tag</span>
						<select name="class">
							<optgroup label="Tag">
								<option value="3am">
									<xsl:if test="@class = '3am'">
										<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
									</xsl:if>
									<xsl:text>3am</xsl:text>
								</option>
								<option value="business">
									<xsl:if test="@class = 'business'">
										<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
									</xsl:if>
									<xsl:text>Business</xsl:text>
								</option>
								<option value="personal">
									<xsl:if test="@class = 'personal'">
										<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
									</xsl:if>
									<xsl:text>Personal</xsl:text>
								</option>
								<option value="probono">
									<xsl:if test="@class = 'probono'">
										<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
									</xsl:if>
									<xsl:text>Pro Bono</xsl:text>
								</option>
								<option value="private">
									<xsl:if test="@class = 'private'">
										<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
									</xsl:if>
									<xsl:text>Private</xsl:text>
								</option>
							</optgroup>
						</select>
						<!--<a class="preview" title="Preview this value" href="http://3amproductions.net/xml/tags/{@class}"><span>Preview</span></a>-->
					</label>
					<label class="manager">
						<span>Manager</span>
						<select name="manager">
							<optgroup label="Manager">
								<option value="">
									<xsl:if test="not(@manager)">
										<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
									</xsl:if>
									<xsl:text></xsl:text>
								</option>
								<option value="gil">
									<xsl:if test="@manager = 'gil'">
										<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
									</xsl:if>
									<xsl:text>Gilbert</xsl:text>
								</option>
								<option value="jason">
									<xsl:if test="@manager = 'jason'">
										<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
									</xsl:if>
									<xsl:text>Jason</xsl:text>
								</option>
							</optgroup>
						</select>
					</label>
					<label class="directory">
						<span>Directory</span>
						<input name="directory" value="{twix:directory}" type="text"/>
					</label>
					<label class="subdomain url">
						<span>Subdomain</span>
						<input name="subdomain" value="{twix:subdomain}" type="text"/>
						<a class="preview" href="subdomain" title="Preview this value">
							<span>Preview</span>
						</a>
					</label>
					<fieldset class="notes">
						<legend>Notes</legend>
						<xsl:apply-templates select="twix:notes/twix:note"/>
						<a class="add" href="note" title="Add Note">
							<span>Add</span>
						</a>
					</fieldset>
				</fieldset>
				<fieldset class="showcase">
					<legend>Showcase</legend>
					<xsl:call-template name="showcase"/>
				</fieldset>
			</form>
		</div>
	</xsl:template>
	<xsl:template name="contact" match="twix:contact">
		<fieldset class="contact">
			<a class="delete" href="contact" title="Delete this Contact">
				<span>Delete</span>
			</a>
			<label class="name">
				<span>Name</span>
				<!--<input name="contact{position()}_name" value="{twix:name}" type="text"/>-->
				<input name="name" value="{twix:name}" type="text"/>
			</label>
			<label class="jobtitle">
				<span>Job Title</span>
				<!--<input name="contact{position()}_jobtitle" value="{twix:jobtitle}" type="text"/>-->
				<input name="jobtitle" value="{twix:jobtitle}" type="text"/>
			</label>
			<label class="role">
				<span>Role</span>
				<!--<input name="contact{position()}_role" value="{twix:role}" type="text"/>-->
				<input name="role" value="{twix:role}" type="text"/>
			</label>
			<fieldset class="emails">
				<legend>Email</legend>
				<xsl:apply-templates select="twix:email"/>
				<a class="add" href="email" title="Add Email">
					<span>Add</span>
				</a>
			</fieldset>
			<fieldset class="phones">
				<legend>Phone</legend>
				<xsl:apply-templates select="twix:phone"/>
				<a class="add" href="phone" title="Add Phone">
					<span>Add</span>
				</a>
			</fieldset>
			<fieldset class="addresses">
				<legend>Address</legend>
				<xsl:apply-templates select="twix:address"/>
				<a class="add" href="address" title="Add Address">
					<span>Add</span>
				</a>
			</fieldset>
		</fieldset>
	</xsl:template>
	<xsl:template name="email" match="twix:email">
		<xsl:variable name="value">
			<xsl:if test="local-name(.) = 'email'">
				<xsl:value-of select="."/>
			</xsl:if>
		</xsl:variable>
		<fieldset class="email">
			<a class="delete" href="email" title="Delete this Email">
				<!--<xsl:attribute name="href"><xsl:text>delete/</xsl:text><xsl:value-of select="../../../@id"/><xsl:text>/contact/</xsl:text><xsl:number count="twix:contact"/><xsl:text>/email/</xsl:text><xsl:value-of select="position()"/><xsl:text>/</xsl:text></xsl:attribute>-->
				<span>Delete</span>
			</a>
			<label class="email">
				<span>Email</span>
				<input name="email" value="{$value}" type="text">
					<!--<xsl:attribute name="name"><xsl:text>contact</xsl:text><xsl:number count="twix:contact"/><xsl:text>_email_</xsl:text><xsl:value-of select="position()"/></xsl:attribute>-->
				</input>
			</label>
			<label class="type">
				<!-- class="email-type" -->
				<span>Email Type</span>
				<select name="type">
					<!-- name="email-type" -->
					<!--<xsl:attribute name="name"><xsl:text>contact</xsl:text><xsl:number count="twix:contact"/><xsl:text>_email-type_</xsl:text><xsl:value-of select="position()"/></xsl:attribute>-->
					<optgroup label="Email Type">
						<option value="personal">
							<xsl:if test="@type = 'personal'">
								<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
							</xsl:if>
							<xsl:text>Personal</xsl:text>
						</option>
						<option value="business">
							<xsl:if test="@type = 'business'">
								<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
							</xsl:if>
							<xsl:text>Business</xsl:text>
						</option>
					</optgroup>
				</select>
			</label>
		</fieldset>
	</xsl:template>
	<xsl:template name="phone" match="twix:phone">
		<xsl:variable name="value">
			<xsl:if test="local-name(.) = 'phone'">
				<xsl:value-of select="."/>
			</xsl:if>
		</xsl:variable>
		<fieldset class="phone">
			<a class="delete" href="phone" title="Delete this Phone">
				<!--<xsl:attribute name="href"><xsl:text>delete/</xsl:text><xsl:value-of select="../../../@id"/><xsl:text>/contact/</xsl:text><xsl:number count="twix:contact"/><xsl:text>/phone/</xsl:text><xsl:value-of select="position()"/><xsl:text>/</xsl:text></xsl:attribute>-->
				<span>Delete</span>
			</a>
			<label class="phone">
				<span>Phone</span>
				<input name="phone" value="{$value}" type="text">
					<!--<xsl:attribute name="name"><xsl:text>contact</xsl:text><xsl:number count="twix:contact"/><xsl:text>_phone_</xsl:text><xsl:value-of select="position()"/></xsl:attribute>-->
				</input>
			</label>
			<label class="type">
				<!-- class="phone-type" -->
				<span>Phone Type</span>
				<select name="type">
					<!--<xsl:attribute name="name"><xsl:text>contact</xsl:text><xsl:number count="twix:contact"/><xsl:text>_phone-type_</xsl:text><xsl:value-of select="position()"/></xsl:attribute>-->
					<optgroup label="Phone Type">
						<option value="home">
							<xsl:if test="@type = 'home'">
								<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
							</xsl:if>
							<xsl:text>Home</xsl:text>
						</option>
						<option value="work">
							<xsl:if test="@type = 'work'">
								<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
							</xsl:if>
							<xsl:text>Work</xsl:text>
						</option>
						<option value="mobile">
							<xsl:if test="@type = 'mobile'">
								<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
							</xsl:if>
							<xsl:text>Mobile</xsl:text>
						</option>
					</optgroup>
				</select>
			</label>
		</fieldset>
	</xsl:template>
	<xsl:template name="address" match="twix:address">
		<fieldset class="address">
			<a class="delete" href="address" title="Delete this Address">
				<!--<xsl:attribute name="href"><xsl:text>delete/</xsl:text><xsl:value-of select="../../../@id"/><xsl:text>/contact/</xsl:text><xsl:number count="twix:contact"/><xsl:text>/address/</xsl:text><xsl:value-of select="position()"/><xsl:text>/</xsl:text></xsl:attribute>-->
				<span>Delete</span>
			</a>
			<label class="type">
				<!-- class="address-type" -->
				<span>Address Type</span>
				<select name="type">
					<!--<xsl:attribute name="name"><xsl:text>contact</xsl:text><xsl:number count="twix:contact"/><xsl:text>_address-type_</xsl:text><xsl:value-of select="position()"/></xsl:attribute>-->
					<optgroup label="Address Type">
						<option value="home">
							<xsl:if test="@type = 'home'">
								<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
							</xsl:if>
							<xsl:text>Home</xsl:text>
						</option>
						<option value="work">
							<xsl:if test="@type = 'work'">
								<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
							</xsl:if>
							<xsl:text>Work</xsl:text>
						</option>
					</optgroup>
				</select>
			</label>
			<label class="street1">
				<span>Street 1</span>
				<input name="street1" value="{twix:street1}" type="text">
					<!--<xsl:attribute name="name"><xsl:text>contact</xsl:text><xsl:number count="twix:contact"/><xsl:text>_street1_</xsl:text><xsl:value-of select="position()"/></xsl:attribute>-->
				</input>
			</label>
			<label class="street2">
				<span>Street 2</span>
				<input name="street2" value="{twix:street2}" type="text">
					<!--<xsl:attribute name="name"><xsl:text>contact</xsl:text><xsl:number count="twix:contact"/><xsl:text>_street2_</xsl:text><xsl:value-of select="position()"/></xsl:attribute>-->
				</input>
			</label>
			<label class="city">
				<span>City</span>
				<input name="city" value="{twix:city}" type="text">
					<!--<xsl:attribute name="name"><xsl:text>contact</xsl:text><xsl:number count="twix:contact"/><xsl:text>_city_</xsl:text><xsl:value-of select="position()"/></xsl:attribute>-->
				</input>
			</label>
			<label class="state">
				<span>State</span>
				<xsl:call-template name="state"/>
				<!--<input name="state" value="{twix:state}" type="text">-->
				<!--<xsl:attribute name="name"><xsl:text>contact</xsl:text><xsl:number count="twix:contact"/><xsl:text>_state_</xsl:text><xsl:value-of select="position()"/></xsl:attribute>-->
			</label>
			<label class="zip">
				<span>Zip Code</span>
				<input name="zip" value="{twix:zip}" type="text">
					<!--<xsl:attribute name="name"><xsl:text>contact</xsl:text><xsl:number count="twix:contact"/><xsl:text>_zip_</xsl:text><xsl:value-of select="position()"/></xsl:attribute>-->
				</input>
			</label>
		</fieldset>
	</xsl:template>
	<xsl:template name="note" match="twix:note">
		<fieldset class="note">
			<a class="delete" href="note" title="Delete this Note">
				<span>Delete</span>
			</a>
			<label class="modified">
				<span>Modified</span>
				<input name="modified" value="{@modified}" type="text" class="date"/>
			</label>
			<label class="by">
				<span>By</span>
				<select name="by">
					<optgroup label="By">
						<option value="gil">
							<xsl:if test="@by = 'gil'">
								<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
							</xsl:if>
							<xsl:text>Gilbert</xsl:text>
						</option>
						<option value="jason">
							<xsl:if test="@by = 'jason'">
								<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
							</xsl:if>
							<xsl:text>Jason</xsl:text>
						</option>
					</optgroup>
				</select>
			</label>
			<label class="remarks">
				<span>Remarks</span>
				<textarea name="note" rows="3" cols="50">
					<xsl:if test="local-name(.) = 'note'">
						<xsl:value-of select="."/>
					</xsl:if>
				</textarea>
			</label>
		</fieldset>
	</xsl:template>
	<xsl:template name="showcase" match="twix:showcase">
		<xsl:choose>
			<xsl:when test="twix:showcase">
				<xsl:apply-templates select="twix:showcase"/>
			</xsl:when>
			<xsl:otherwise>
				<label class="title">
					<span>Showcase Title</span>
					<input name="title" value="{twix:title}" type="text"/>
				</label>
				<label class="description">
					<span>Description</span>
					<textarea name="description" rows="5" cols="75">
						<xsl:apply-templates select="twix:description" mode="no-namespace-copy-of"/>
					</textarea>
				</label>
				<fieldset>
					<legend>Images</legend>
					<fieldset class="feature">
						<legend>Feature</legend>
						<xsl:call-template name="feature"/>
					</fieldset>
					<fieldset class="screenshots">
						<legend>Screenshots</legend>
						<xsl:apply-templates select="twix:images/twix:screenshot"/>
						<a class="add" href="screenshot" title="Add Screenshot">
							<span>Add</span>
						</a>
					</fieldset>
				</fieldset>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>
	<xsl:template name="feature" match="twix:feature">
		<xsl:choose>
			<xsl:when test="twix:images/twix:feature">
				<xsl:apply-templates select="twix:images/twix:feature"/>
			</xsl:when>
			<xsl:otherwise>
				<label class="src">
					<span>Main</span>
					<input name="src" value="{twix:src}" type="text" class="url"/>
					<a class="preview" href="image" title="Preview this Image">
						<span>Preview</span>
					</a>
				</label>
				<label class="thumbnail">
					<span>Thumbnail</span>
					<input name="thumbnail" value="{twix:thumbnail}" type="text" class="url"/>
					<a class="preview" href="image" title="Preview this Image">
						<span>Preview</span>
					</a>
				</label>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>
	<xsl:template name="screenshot" match="twix:screenshot">
		<fieldset class="screenshot">
			<a class="delete" href="screenshot" title="Delete this Screenshot">
				<span>Delete</span>
			</a>
			<label class="src">
				<span>Main</span>
				<input name="src" value="{twix:src}" type="text" class="url"/>
				<a class="preview" href="image" title="Preview this Image">
					<span>Preview</span>
				</a>
			</label>
			<label class="thumbnail">
				<span>Thumbnail</span>
				<input name="thumbnail" value="{twix:thumbnail}" type="text" class="url"/>
				<a class="preview" href="image" title="Preview this Image">
					<span>Preview</span>
				</a>
			</label>
		</fieldset>
	</xsl:template>
	<xsl:template name="state">
		<select name="state">
			<optgroup label="State">
				<option value="">
					<xsl:if test="not(twix:state)">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if></option>
				<option value="AL">
					<xsl:if test="twix:state/@abbr = 'AL'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>Alabama</option>
				<option value="AK">
					<xsl:if test="twix:state/@abbr = 'AK'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>Alaska</option>
				<option value="AZ">
					<xsl:if test="twix:state/@abbr = 'AZ'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>Arizona</option>
				<option value="AR">
					<xsl:if test="twix:state/@abbr = 'AR'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>Arkansas</option>
				<option value="CA">
					<xsl:if test="twix:state/@abbr = 'CA'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>California</option>
				<option value="CO">
					<xsl:if test="twix:state/@abbr = 'CO'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>Colorado</option>
				<option value="CT">
					<xsl:if test="twix:state/@abbr = 'CT'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>Connecticut</option>
				<option value="DE">
					<xsl:if test="twix:state/@abbr = 'DE'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>Delaware</option>
				<option value="DC">
					<xsl:if test="twix:state/@abbr = 'DC'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>District Of Columbia</option>
				<option value="FL">
					<xsl:if test="twix:state/@abbr = 'FL'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>Florida</option>
				<option value="GA">
					<xsl:if test="twix:state/@abbr = 'GA'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>Georgia</option>
				<option value="HI">
					<xsl:if test="twix:state/@abbr = 'HI'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>Hawaii</option>
				<option value="ID">
					<xsl:if test="twix:state/@abbr = 'ID'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>Idaho</option>
				<option value="IL">
					<xsl:if test="twix:state/@abbr = 'IL'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>Illinois</option>
				<option value="IN">
					<xsl:if test="twix:state/@abbr = 'IN'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>Indiana</option>
				<option value="IA">
					<xsl:if test="twix:state/@abbr = 'IA'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>Iowa</option>
				<option value="KS">
					<xsl:if test="twix:state/@abbr = 'KS'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>Kansas</option>
				<option value="KY">
					<xsl:if test="twix:state/@abbr = 'KY'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>Kentucky</option>
				<option value="LA">
					<xsl:if test="twix:state/@abbr = 'LA'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>Louisiana</option>
				<option value="ME">
					<xsl:if test="twix:state/@abbr = 'ME'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>Maine</option>
				<option value="MD">
					<xsl:if test="twix:state/@abbr = 'MD'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>Maryland</option>
				<option value="MA">
					<xsl:if test="twix:state/@abbr = 'MA'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>Massachusetts</option>
				<option value="MI">
					<xsl:if test="twix:state/@abbr = 'MI'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>Michigan</option>
				<option value="MN">
					<xsl:if test="twix:state/@abbr = 'MN'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>Minnesota</option>
				<option value="MS">
					<xsl:if test="twix:state/@abbr = 'MS'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>Mississippi</option>
				<option value="MO">
					<xsl:if test="twix:state/@abbr = 'MO'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>Missouri</option>
				<option value="MT">
					<xsl:if test="twix:state/@abbr = 'MT'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>Montana</option>
				<option value="NE">
					<xsl:if test="twix:state/@abbr = 'NE'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>Nebraska</option>
				<option value="NV">
					<xsl:if test="twix:state/@abbr = 'NV'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>Nevada</option>
				<option value="NH">
					<xsl:if test="twix:state/@abbr = 'NH'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>New Hampshire</option>
				<option value="NJ">
					<xsl:if test="twix:state/@abbr = 'NJ'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>New Jersey</option>
				<option value="NM">
					<xsl:if test="twix:state/@abbr = 'NM'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>New Mexico</option>
				<option value="NY">
					<xsl:if test="twix:state/@abbr = 'NY'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>New York</option>
				<option value="NC">
					<xsl:if test="twix:state/@abbr = 'NC'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>North Carolina</option>
				<option value="ND">
					<xsl:if test="twix:state/@abbr = 'ND'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>North Dakota</option>
				<option value="OH">
					<xsl:if test="twix:state/@abbr = 'OH'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>Ohio</option>
				<option value="OK">
					<xsl:if test="twix:state/@abbr = 'OK'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>Oklahoma</option>
				<option value="OR">
					<xsl:if test="twix:state/@abbr = 'OR'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>Oregon</option>
				<option value="PA">
					<xsl:if test="twix:state/@abbr = 'PA'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>Pennsylvania</option>
				<option value="RI">
					<xsl:if test="twix:state/@abbr = 'RI'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>Rhode Island</option>
				<option value="SC">
					<xsl:if test="twix:state/@abbr = 'SC'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>South Carolina</option>
				<option value="SD">
					<xsl:if test="twix:state/@abbr = 'SD'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>South Dakota</option>
				<option value="TN">
					<xsl:if test="twix:state/@abbr = 'TN'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>Tennessee</option>
				<option value="TX">
					<xsl:if test="twix:state/@abbr = 'TX'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>Texas</option>
				<option value="UT">
					<xsl:if test="twix:state/@abbr = 'UT'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>Utah</option>
				<option value="VT">
					<xsl:if test="twix:state/@abbr = 'VT'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>Vermont</option>
				<option value="VA">
					<xsl:if test="twix:state/@abbr = 'VA'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>Virginia</option>
				<option value="WA">
					<xsl:if test="twix:state/@abbr = 'WA'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>Washington</option>
				<option value="WV">
					<xsl:if test="twix:state/@abbr = 'WV'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>West Virginia</option>
				<option value="WI">
					<xsl:if test="twix:state/@abbr = 'WI'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>Wisconsin</option>
				<option value="WY">
					<xsl:if test="twix:state/@abbr = 'WY'">
						<xsl:attribute name="selected"><xsl:text>selected</xsl:text></xsl:attribute>
					</xsl:if>Wyoming</option>
			</optgroup>
		</select>
	</xsl:template>
	<xsl:template match="xhtml:*" mode="no-namespace-copy-of">
		<xsl:text>&lt;</xsl:text>
		<xsl:value-of select="local-name(.)"/>
		<xsl:for-each select="@*">
			<xsl:text> </xsl:text>
			<xsl:value-of select="local-name(.)"/>
			<xsl:text>="</xsl:text>
			<xsl:value-of select="."/>
			<xsl:text>"</xsl:text>
		</xsl:for-each>
		<xsl:text>&gt;</xsl:text>
		<xsl:apply-templates mode="no-namespace-copy-of"/>
		<xsl:text>&lt;/</xsl:text>
		<xsl:value-of select="local-name(.)"/>
		<xsl:text>&gt;</xsl:text>
	</xsl:template>
</xsl:stylesheet>
