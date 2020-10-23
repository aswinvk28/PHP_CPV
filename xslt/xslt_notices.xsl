<?xml version="1.0" encoding="utf-8" standalone="yes"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.1">
    
    <xsl:output method="html" />
    
    <xsl:template match="/">
        <xsl:apply-templates select="FEED/NOTICES" />
    </xsl:template>
    
    <xsl:template match="NOTICES">
        <notices><xsl:apply-templates select="CONTRACT|CONTRACT_AWARD|PRIOR_INFORMATION" /></notices>
    </xsl:template>
    
    <xsl:template name="CPV_CODE">
        <code>
            <xsl:value-of select="@CODE"/>
        </code>
    </xsl:template>
    
    <xsl:template name="RANGE_VALUE_COST_LOW_VALUE">
        <min>
            <xsl:value-of select="RANGE_VALUE_COST/LOW_VALUE" />
        </min>
    </xsl:template>
    
    <xsl:template name="RANGE_VALUE_COST_HIGH_VALUE">
        <max>
            <xsl:value-of select="RANGE_VALUE_COST/HIGH_VALUE" />
        </max>
    </xsl:template>
    
    <xsl:template name="NOTICE_ID">
        <notice_id><xsl:value-of select="NOTICE_ID" /></notice_id>
    </xsl:template>
    
    <xsl:template name="PARENT_NOTICE_ID">
        <parent_notice_id><xsl:value-of select="PARENT_NOTICE_ID" /></parent_notice_id>
    </xsl:template>
    
    <xsl:template name="ROOT_NOTICE_ID">
        <root_notice_id><xsl:value-of select="ROOT_NOTICE_ID" /></root_notice_id>
    </xsl:template>
    
    <xsl:template name="NOTICE_GROUP">
        <notice_group><xsl:value-of select="NOTICE_GROUP" /></notice_group>
    </xsl:template>
    
    <xsl:template name="NOTICE_TYPE">
        <notice_type><xsl:value-of select="NOTICE_TYPE" /></notice_type>
    </xsl:template>
    
    <xsl:template name="NOTICE_TYPE_FRIENDLY_NAME">
        <notice_type_friendly_name><xsl:value-of select="NOTICE_TYPE_FRIENDLY_NAME" /></notice_type_friendly_name>
    </xsl:template>
    
    <xsl:template name="NOTICE_STATE">
        <notice_state><xsl:value-of select="NOTICE_STATE" /></notice_state>
    </xsl:template>
    
    <xsl:template name="SYSTEM_NOTICE_STATE">
        <system_notice_state><xsl:value-of select="SYSTEM_NOTICE_STATE" /></system_notice_state>
    </xsl:template>
    
    <xsl:template name="SYSTEM_PUBLISHED_DATE">
        <system_published_date><xsl:value-of select="SYSTEM_PUBLISHED_DATE" /></system_published_date>
    </xsl:template>
    
    <xsl:template name="SYSTEM_NOTICE_STATE_CHANGE_DATE">
        <system_notice_state_change_date><xsl:value-of select="SYSTEM_NOTICE_STATE_CHANGE_DATE" /></system_notice_state_change_date>
    </xsl:template>
    
    <xsl:template name="BUYER_GROUP_ID">
        <buyer_group_id><xsl:value-of select="BUYER_GROUP_ID" /></buyer_group_id>
    </xsl:template>
    
    <xsl:template name="BUYER_GROUP_NAME">
        <buyer_group_name><xsl:value-of select="BUYER_GROUP_NAME" /></buyer_group_name>
    </xsl:template>
    
    <xsl:template match="CONTRACT">
        <contract type="contract">
           <xsl:apply-templates select="FD_CONTRACT" />
           <xsl:apply-templates select="SYSTEM" />
        </contract>
    </xsl:template>
    
    <xsl:template match="PRIOR_INFORMATION">
        <contract type="prior_information">
            <xsl:apply-templates select="FD_PRIOR_INFORMATION" />
            <xsl:apply-templates select="SYSTEM" />
        </contract>
    </xsl:template>
    
    <xsl:template match="CONTRACT_AWARD">
        <contract type="contract_award">
            <xsl:apply-templates select="FD_CONTRACT_AWARD" />
            <xsl:apply-templates select="SYSTEM" />
        </contract>
    </xsl:template>
    
    <xsl:template match="FD_CONTRACT|FD_PRIOR_INFORMATION|FD_CONTRACT_AWARD">
        <!--<xsl:apply-templates select=".//SITE_OR_LOCATION" />-->
        <xsl:apply-templates select=".//CPV" />
        <budget><xsl:apply-templates select=".//COSTS_RANGE_AND_CURRENCY" /></budget>
        <xsl:apply-templates select=".//COSTS_RANGE_AND_CURRENCY_WITH_VAT_RATE" />
        <contract_award_date><xsl:apply-templates select=".//CONTRACT_AWARD_DATE" /></contract_award_date>
        <xsl:apply-templates select=".//PERIOD_WORK_DATE_STARTING" />
        <xsl:apply-templates select=".//RECEIPT_LIMIT_DATE" />
        <xsl:apply-templates select=".//DELIVERY_LOCATION" />
    </xsl:template>
    
    <xsl:template match="SITE_OR_LOCATION">
        <xsl:value-of select="LABEL" />
        <xsl:value-of select="LOCATION" />
    </xsl:template>
    
    <xsl:template match="CPV">
        <maincode>
            <xsl:apply-templates select="CPV_MAIN" />
        </maincode>
        <addcode>
            <xsl:apply-templates select="CPV_ADDITIONAL" />
        </addcode>
    </xsl:template>
    
    <xsl:template match="CPV_MAIN|CPV_ADDITIONAL">
        <xsl:for-each select="CPV_CODE">
            <xsl:call-template name="CPV_CODE"></xsl:call-template>
        </xsl:for-each>
    </xsl:template>
    
    <xsl:template match="COSTS_RANGE_AND_CURRENCY">
        <xsl:call-template name="RANGE_VALUE_COST_LOW_VALUE"></xsl:call-template>
        <xsl:call-template name="RANGE_VALUE_COST_HIGH_VALUE"></xsl:call-template>
    </xsl:template>
    
    <xsl:template match="COSTS_RANGE_AND_CURRENCY_WITH_VAT_RATE">
        <estimate>
            <xsl:value-of select="VALUE_COST" />
        </estimate>
    </xsl:template>
    
    <xsl:template match="PERIOD_WORK_DATE_STARTING">
        <duration>
            <year>
                <xsl:value-of select="YEAR" />
            </year>
            <months>
                <xsl:value-of select="MONTHS"/>
            </months>
            <days>
                <xsl:value-of select="DAYS"/>
            </days>
        </duration>
    </xsl:template>
    
    <xsl:template match="PERIOD_WORK_DATE_STARTING">
        <date><start><xsl:apply-templates select="INTERVAL_DATE/START_DATE" /></start>
            <end><xsl:apply-templates select="INTERVAL_DATE/END_DATE" /></end></date>
    </xsl:template>
    
    <xsl:template match="START_DATE|END_DATE|CONTRACT_AWARD_DATE">
        <xsl:value-of select="YEAR"/>/<xsl:value-of select="MONTH" />/<xsl:value-of select="DAY" />
    </xsl:template>
    
    <xsl:template match="RECEIPT_LIMIT_DATE">
        <deadline>
            <xsl:value-of select="YEAR"/>/<xsl:value-of select="MONTH" />/<xsl:value-of select="DAY" />
            <xsl:text> </xsl:text> 
            <xsl:value-of select="TIME" />
        </deadline>
    </xsl:template>
    
    <xsl:template match="DELIVERY_LOCATION">
        <xsl:value-of select="TOWN" />
        <xsl:value-of select="COUNTY" />
        <xsl:value-of select="COUNTRY" />
        <xsl:value-of select="POSTAL_CODE" />
        <xsl:value-of select="LOCATION_ADDITIONAL_FREE_TEXT" />
    </xsl:template>
    
    <xsl:template match="SYSTEM">
        <system>
            <xsl:call-template name="NOTICE_ID"></xsl:call-template>
            <xsl:call-template name="PARENT_NOTICE_ID"></xsl:call-template>
            <xsl:call-template name="ROOT_NOTICE_ID"></xsl:call-template>
            <xsl:call-template name="NOTICE_GROUP"></xsl:call-template>
            <xsl:call-template name="NOTICE_TYPE"></xsl:call-template>
            <xsl:call-template name="NOTICE_TYPE_FRIENDLY_NAME"></xsl:call-template>
            <xsl:call-template name="NOTICE_STATE"></xsl:call-template>
            <xsl:call-template name="SYSTEM_NOTICE_STATE"></xsl:call-template>
            <xsl:call-template name="SYSTEM_PUBLISHED_DATE"></xsl:call-template>
            <xsl:call-template name="SYSTEM_NOTICE_STATE_CHANGE_DATE"></xsl:call-template>
            <xsl:call-template name="BUYER_GROUP_ID"></xsl:call-template>
            <xsl:call-template name="BUYER_GROUP_NAME"></xsl:call-template>
        </system>
    </xsl:template>
    
</xsl:stylesheet>